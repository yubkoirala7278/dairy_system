<?php

namespace App\Livewire\Admin\Dairy;

use App\Exports\MilkDepositIncomeExport;
use App\Models\Account;
use App\Models\MilkIncome;
use App\Models\Transaction;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Accounting extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $page = 'farmer';
    public $search = '';
    private $transactionRepository;
    public $entries =10;
    public $incomes = [];
    public $selectAll = false;
    public $milk_deposit_date;

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatedEntries()
    {
        $this->resetPage();
    }
    public function boot(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function render()
    {
        $milkDepositsIncome = $this->transactionRepository->getMilkDepositIncome($this->entries, $this->search, $this->milk_deposit_date);
        $totals = $this->transactionRepository->getTotalMilkIncomeWithFilters( $this->search, $this->milk_deposit_date);
        return view('livewire.admin.dairy.accounting', [
            'milkDepositsIncome' => $milkDepositsIncome,
            'totalMilkQuantity' => $totals['total_milk_quantity_nepali'],
            'totalMilkTotalPrice' =>  $totals['total_milk_price_nepali'],
        ]);
    }

    public function depositMilkIncome()
    {
        try {
            if (!$this->incomes) {
                $this->dispatch('warningMessage', title: 'कृपया कम्तिमा एक जना कृषकको दूध डिपोजिट आय छान्नुहोस्।');
                return;
            }
            $this->dispatch('warning', title: "के तपाईं चयनित किसानहरूको पैसा जम्मा गर्न चाहनुहुन्छ?");
        } catch (\Throwable $th) {
            $this->dispatch('error', title: $th->getMessage());
        }
    }
    public function confirmDepositMilkIncome()
    {
        DB::beginTransaction(); // Begin the transaction

        try {
            // Check if any incomes are selected
            if (count($this->incomes) > 0) {
                // Get the milk incomes for the selected IDs
                $milkIncomes = MilkIncome::whereIn('id', $this->incomes)->get();

                // Group the milk incomes by user_id and sum the deposits
                $deposits = $milkIncomes->groupBy('user_id')->map(function ($group) {
                    return [
                        'user_id' => $group->first()->user_id,
                        'deposit' => $group->sum('deposit'), // Sum deposits for each user
                    ];
                })->values()->toArray();

                foreach ($deposits as $key => $deposit) {
                    // Find the user's account or create one if it doesn't exist
                    $account = Account::firstOrCreate(
                        ['user_id' => $deposit['user_id']],
                        ['balance' => 0]
                    );

                    // Update account balance
                    $account->increment('balance', $deposit['deposit']);

                    // Record transaction
                    Transaction::create([
                        'account_id' => $account->id,
                        'type' => 'deposit',
                        'amount' => $deposit['deposit'],
                    ]);
                }

                // Delete the selected milk incomes
                MilkIncome::whereIn('id', $this->incomes)->delete();

                DB::commit(); // Commit the transaction

                // Reset the incomes array
                $this->incomes = [];
                $this->resetPage();

                // Dispatch success message
                $this->dispatch('success', title: 'चयनित किसानहरूको पैसा सफलतापूर्वक जम्मा गरिएको छ।');
            } else {
                // If no incomes are selected, dispatch a warning
                $this->dispatch('warningMessage', title: 'कृपया किसान चयन गर्नुहोस्।');
            }
        } catch (\Throwable $th) {
            DB::rollBack(); // Rollback in case of an error
            // Dispatch error message
            $this->dispatch('error', title: $th->getMessage());
        }
    }

    public function updatedSelectAll()
    {
        // Start the query for MilkIncome with relations and sum aggregations
        $query = MilkIncome::with('user', 'milkDeposits')
            ->orderBy('created_at', 'asc'); // Order by the latest entries

        // Apply keyword filter for user attributes like name, email, or other attributes
        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('user', function ($query) {
                    $query->where('owner_name', 'like', '%' . $this->search . '%')
                    ->orWhere('farmer_number', '=', $this->search);
                })
                    ->orWhereHas('milkDeposits', function ($query) {
                        $query->where('milk_deposit_time', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Apply filter for milk_deposit_date if provided
        if ($this->milk_deposit_date) {
            $query->whereHas('milkDeposits', function ($query) {
                $query->where('milk_deposit_date', '=', $this->milk_deposit_date);
            });
        }

        // If 'selectAll' is checked, get all IDs, else return an empty array
        if ($this->selectAll) {
            $this->incomes = $query->pluck('id')->toArray();
        } else {
            $this->incomes = [];
        }
    }

    // export excel
    public function exportToExcel()
    {
        $milkDepositsIncome = $this->transactionRepository->getMilkDepositIncomeForExport($this->search, $this->milk_deposit_date);
        if($milkDepositsIncome->isEmpty()){
            $this->dispatch('warningMessage', title: 'डाउनलोड गर्न मिल्ने कुनै दुध जम्मा आम्दानी उपलब्ध छैन।');
            return;
        }
        $totals = $this->transactionRepository->getTotalMilkIncomeWithFilters( $this->search, $this->milk_deposit_date);
        return Excel::download(new MilkDepositIncomeExport($milkDepositsIncome,$totals), 'milk_deposit_income.xlsx');
    }
    // export pdf
    public function printUsers()
    {
        $url = route('admin.accounting.print', [
            'milk_deposit_date' => $this->milk_deposit_date?$this->milk_deposit_date:'no-date',
            'search' => $this->search ?? null,
        ]);
        $this->dispatch('open-new-tab', url: $url);
    }
}
