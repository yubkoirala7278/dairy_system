<?php

namespace App\Livewire\Admin\Dairy;

use App\Exports\MilkDepositExport;
use App\Models\MilkDeposit as ModelsMilkDeposit;
use App\Models\Setup;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Livewire\WithPagination;
use App\Helpers\NumberHelper;
use App\Models\MilkIncome;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class MilkDeposit extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    private $userRepository;
    public $page = 'farmer';
    public $farmernumber;
    public $owner_name,
        $location,
        $phone_number,
        $milk_fat = 0,
        $milk_snf = 0,
        $milkQuantity,
        $per_litre_commission = 0,
        $per_litre_price,
        $milk_type = 'मिश्रित',
        $gov_snf,
        $gov_fat,
        $total_milk_price,
        $milk_deposit_date,
        $milk_deposit_time = 'बिहान';
    public $entries = 10;
    public $search = '';
    public $milk_deposit_id;
    public $user_id;

    public function resetFields()
    {
        $this->reset([
            'farmernumber',
            'per_litre_commission',
            'milkQuantity',
            'milk_fat',
            'milk_snf',
            'milk_deposit_id',
            'user_id'
        ]);
        $this->resetErrorBag();
    }

    public function updatedEntries()
    {
        $this->resetPage('page');
    }

    // ==========filter=========
    public function updatingSearch()
    {
        $this->resetPage();
    }



    public function boot(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function mount()
    {
        $setup = Setup::latest()->first(['gov_snf', 'gov_fat']);
        $this->gov_snf = $setup->gov_snf;
        $this->gov_fat = $setup->gov_fat;
    }
    public function milkPriceUpdation()
    {
        $this->per_litre_price = round(((float)$this->milk_snf * $this->gov_snf) + ((float)$this->milk_fat * $this->gov_fat), 4) + (float)$this->per_litre_commission;
        $this->total_milk_price = round((float)$this->milkQuantity * $this->per_litre_price, 4);
    }
    public function updatedMilkFat()
    {
        $this->milkPriceUpdation();
    }
    public function updatedMilkSnf()
    {
        $this->milkPriceUpdation();
    }
    public function updatedPerLitreCommission()
    {
        $this->milkPriceUpdation();
    }
    public function updatedFarmernumber()
    {
        $user = User::where('farmer_number', $this->farmernumber)->first();
        if (!$user) {
            $this->reset(['owner_name', 'location', 'phone_number']);
            return;
        }
        $this->owner_name = $user->owner_name;
        $this->location = $user->location;
        $this->phone_number = $user->phone_number;
        $this->milk_fat = $user->milk_fat ?? 0;
        $this->milk_snf = $user->milk_snf ?? 0;
        $this->per_litre_price = round(($this->milk_snf * $this->gov_snf) + ($this->milk_fat * $this->gov_fat), 4);
    }
    public function updatedMilkQuantity()
    {
        $this->total_milk_price = round((float)$this->milkQuantity * $this->per_litre_price, 4);
    }
    public function render()
    {
        $milkDeposits = $this->userRepository->getMilkDeposits($this->entries, $this->search, $this->milk_deposit_date, $this->milk_deposit_time, $this->milk_type);
        $milkInfo = $this->userRepository->getTotalIncomeFromMilkOnSpecificDate($this->milk_deposit_date, $this->milk_deposit_time, $this->entries, $this->search);
        $totalDepositIncome = NumberHelper::toNepaliNumber($milkInfo['totalDepositIncome']);
        $totalDepositedMilk = NumberHelper::toNepaliNumber($milkInfo['totalDepositedMilk']);
        return view('livewire.admin.dairy.milk-deposit', [
            'milkDeposits' => $milkDeposits,
            'totalDepositIncome' => $totalDepositIncome,
            'totalMilkQuantity' => $totalDepositedMilk
        ]);
    }

    protected $rules = [
        'farmernumber' => 'required',
        'milkQuantity' => 'required',
        'milk_fat' => 'required|min:1|numeric',
        'milk_snf' => 'required|min:1|numeric',
        'per_litre_commission' => 'nullable|numeric',
        'per_litre_price' => 'required|numeric',
        'milk_deposit_date' => 'required'
    ];

    protected $messages = [
        'farmernumber.required' => 'कृषक नम्बर आवश्यक छ।',
        'milkQuantity.required' => 'दूधको मात्रा आवश्यक छ।',
        'milk_fat.required' => 'दूधको फ्याट आवश्यक छ।',
        'milk_fat.min' => 'दूधको फ्याट कम्तिमा १ हुनु पर्छ।',
        'milk_fat.numeric' => 'दूधको फ्याट संख्यामा हुनुपर्छ।',
        'milk_snf.required' => 'दूधको एस.एन.एफ आवश्यक छ।',
        'milk_snf.min' => 'दूधको एस.एन.एफ कम्तिमा १ हुनु पर्छ।',
        'milk_snf.numeric' => 'दूधको एस.एन.एफ संख्यामा हुनुपर्छ।',
        'per_litre_commission.nullable' => 'प्रति लिटर कमिशन आवश्यक छैन।',
        'per_litre_commission.numeric' => 'प्रति लिटर कमिशन संख्यामा हुनुपर्छ।',
        'per_litre_price.required' => 'प्रति लिटर रकम आवश्यक छ।',
        'per_litre_price.numeric' => 'प्रति लिटर रकम संख्यामा हुनुपर्छ।',
        'milk_deposit_date.required' => 'दूध सङ्कलन मिति आवश्यक छ।',
    ];


    public function register()
    {
        $this->validate();
        $user = User::where('farmer_number', $this->farmernumber)->first();
        if (!$user) {
            $this->dispatch('warningMessage', title: "कृषक नम्बर {$this->farmernumber} दर्ता भएको छैन।");
            $this->resetFields();
            return;
        }
        if ($this->milk_deposit_id) {
            $this->user_id = $user->id;
            $this->update();
            return;
        }
        try {
            $milkDeposit = ModelsMilkDeposit::where('user_id', $user->id)->where('milk_deposit_date', $this->milk_deposit_date)->where('milk_deposit_time', $this->milk_deposit_time)->first();
            if ($milkDeposit) {
                $this->dispatch('warningMessage', title: 'यो दूधको अभिलेख पहिले नै राखिएको छ।');
                $this->resetFields();
                return;
            }
            $user->update([
                'milk_fat' => $this->milk_fat,
                'milk_snf' => $this->milk_snf
            ]);
            $milk_deposit = ModelsMilkDeposit::create([
                'user_id' => $user->id,
                'milk_quantity' => $this->milkQuantity,
                'milk_fat' => $this->milk_fat,
                'milk_snf' => $this->milk_snf,
                'milk_price_per_ltr' => $this->per_litre_price,
                'per_ltr_commission' => $this->per_litre_commission,
                'milk_per_ltr_price_with_commission' => $this->per_litre_price + $this->per_litre_commission,
                'milk_total_price' => $this->total_milk_price,
                'milk_deposit_date' => $this->milk_deposit_date,
                'milk_deposit_time' => $this->milk_deposit_time,
                'milk_type' => $this->milk_type
            ]);
            MilkIncome::create([
                'user_id' => $user->id,
                'deposit' => $this->total_milk_price,
                'milk_deposits_id' => $milk_deposit->id
            ]);
            $this->resetFields();
            $this->dispatch('success', title: 'डेटा सफलतापूर्वक सुरक्षित भयो।');
        } catch (\Throwable $th) {
            $this->dispatch('error', title: $th->getMessage());
        }
    }


    // ============update===================
    public function edit($id)
    {
        try {
            $deposit = ModelsMilkDeposit::with('user')->find($id);
            if (!$deposit) {
                $this->dispatch('warningMessage', title: "कृषक नम्बर दर्ता भएको छैन।");
                return;
            }
            $milkIncome = MilkIncome::where('milk_deposits_id', $deposit->id)->first();
            if (!$milkIncome) {
                $this->dispatch('warningMessage', title: "कृषक नम्बर {$deposit->user->farmer_number} को राशी पहिले नै मुख्य खातामा जम्मा भइसकेको छ, यसकारण यसलाई अभिलेख गर्न सकिँदैन।");
                return;
            }
            $this->milkQuantity = $deposit->milk_quantity;
            $this->milk_fat = $deposit->milk_fat;
            $this->milk_snf = $deposit->milk_snf;
            $this->per_litre_price = $deposit->milk_price_per_ltr;
            $this->per_litre_commission = $deposit->per_ltr_commission;
            $this->total_milk_price = $deposit->milk_total_price;
            $this->milk_deposit_date = $deposit->milk_deposit_date;
            $this->milk_deposit_time = $deposit->milk_deposit_time;
            $this->milk_type = $deposit->milk_type;
            $this->farmernumber = $deposit->user->farmer_number;
            $this->owner_name = $deposit->user->owner_name;
            $this->location = $deposit->user->location;
            $this->phone_number = $deposit->user->phone_number;
            $this->milk_deposit_id = $id;
        } catch (\Throwable $th) {
            $this->dispatch('error', title: $th->getMessage());
        }
    }
    public function update()
    {
        $milkDeposit = ModelsMilkDeposit::where('user_id', $this->user_id)->where('milk_deposit_date', $this->milk_deposit_date)->where('milk_deposit_time', $this->milk_deposit_time)->first();
        if ($milkDeposit && $milkDeposit->id != $this->milk_deposit_id) {
            $this->dispatch('warningMessage', title: 'यो दूधको अभिलेख पहिले नै राखिएको छ।');
            $this->resetFields();
            return;
        }
        $this->dispatch('warning');
    }
    public function confirmUpdate()
    {
        try {
            $milkDeposit = ModelsMilkDeposit::where('id', $this->milk_deposit_id)->first();
            $milkDeposit->update([
                'user_id' => $this->user_id,
                'milk_quantity' => $this->milkQuantity,
                'milk_fat' => $this->milk_fat,
                'milk_snf' => $this->milk_snf,
                'milk_price_per_ltr' => $this->per_litre_price,
                'per_ltr_commission' => $this->per_litre_commission,
                'milk_per_ltr_price_with_commission' => $this->per_litre_price + $this->per_litre_commission,
                'milk_total_price' => $this->total_milk_price,
                'milk_deposit_date' => $this->milk_deposit_date,
                'milk_deposit_time' => $this->milk_deposit_time,
                'milk_type' => $this->milk_type
            ]);
            $deposit = MilkIncome::where('milk_deposits_id', $milkDeposit->id)->first();
            $deposit->update([
                'user_id' => $this->user_id,
                'deposit' => $this->total_milk_price,
                'milk_deposits_id' => $milkDeposit->id
            ]);
            $this->resetFields();
            $this->dispatch('success', title: 'डेटा सफलतापूर्वक सुरक्षित भयो।');
        } catch (\Throwable $th) {
            $this->dispatch('error', title: $th->getMessage());
        }
    }

    // =========delete milk deposits=======
    public function delete($id)
    {
        try {
            $milkDeposit = ModelsMilkDeposit::where('id', $id)->first();
            if (!$milkDeposit) {
                $this->dispatch('warningMessage', title: "कृषक नम्बर दर्ता भएको छैन।");
                return;
            }
            $milkIncome = MilkIncome::where('milk_deposits_id', $milkDeposit->id)->first();
            if (!$milkIncome) {
                $this->dispatch('warningMessage', title: "कृषक नम्बर {$milkDeposit->user->farmer_number} को राशी पहिले नै मुख्य खातामा जम्मा भइसकेको छ, त्यसैले यसलाई मेट्न सकिँदैन।");
                return;
            }
            $milkIncome->delete();
            $milkDeposit->delete();
            $this->dispatch('success', title: 'डाटा मेटाइएको छ।');
        } catch (\Throwable $th) {
            $this->dispatch('error', title: $th->getMessage());
        }
    }


    // export pdf
    public function printMilkDeposits()
    {
        if (!$this->milk_deposit_date || !$this->milk_deposit_time) {
            $this->dispatch('warningMessage', title: 'दूध सङ्कलन मिति र दूध जम्मा समय आवश्यक छ!');
            return;
        }
        $url = route('admin.milk.deposit.print', [
            'milk_deposit_date' => $this->milk_deposit_date,
            'milk_deposit_time' => $this->milk_deposit_time,
            'search' => $this->search ?? null,
        ]);
        $this->dispatch('open-new-tab', url: $url);
    }
    // export excel
    public function exportToExcel()
    {
        if (!$this->milk_deposit_date || !$this->milk_deposit_time) {
            $this->dispatch('warningMessage', title: 'कृपया दूध जम्मा गर्ने मिति र समय चयन गर्नुहोस्!');
            return;
        }
        $milkDeposits = ModelsMilkDeposit::with('user')
            ->where('milk_deposit_date', $this->milk_deposit_date)
            ->where('milk_deposit_time', $this->milk_deposit_time)
            ->join('users', 'users.id', '=', 'milk_deposits.user_id')
            ->orderBy('users.id', 'asc')
            ->get();
        if (count($milkDeposits) <= 0) {
            $this->dispatch('warningMessage', title: 'डाउनलोड गर्नको लागि कुनै दूध जम्मा उपलब्ध छैन!');
            return;
        }

        $milkDeposits->transform(function ($deposit) {
            $deposit->milk_per_ltr_price_with_commission = NumberHelper::toNepaliNumber($deposit->milk_per_ltr_price_with_commission);
            $deposit->milk_snf = NumberHelper::toNepaliNumber($deposit->milk_snf);
            $deposit->milk_fat = NumberHelper::toNepaliNumber($deposit->milk_fat);
            $deposit->milk_quantity = NumberHelper::toNepaliNumber($deposit->milk_quantity);
            $deposit->milk_total_price = NumberHelper::toNepaliNumber($deposit->milk_total_price);

            return $deposit;
        });
        // Retrieve the sum of both milk_quantity and milk_total_price in a single query
        $totals = ModelsMilkDeposit::where('milk_deposit_date', $this->milk_deposit_date)
            ->where('milk_deposit_time', $this->milk_deposit_time)
            ->selectRaw('sum(milk_quantity) as total_milk_deposits, sum(milk_total_price) as total_milk_price')
            ->first();

        // Convert the totals to Nepali numbers
        $total_milk_deposits = NumberHelper::toNepaliNumber($totals->total_milk_deposits);
        $total_milk_price = NumberHelper::toNepaliNumber($totals->total_milk_price);

        if (!$milkDeposits) {
            $this->dispatch('error', title: 'डाउनलोड गर्नको लागि कुनै दूध जम्मा छैन!');
            return;
        }
        return Excel::download(
            new MilkDepositExport($milkDeposits, $total_milk_deposits, $total_milk_price, $this->milk_deposit_date, $this->milk_deposit_time),
            'milk_deposits_' . $this->milk_deposit_date . '_' . $this->milk_deposit_time . '.xlsx'
        );
    }
}
