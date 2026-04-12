<?php

namespace App\Livewire\Admin\Dairy;

use Livewire\WithPagination;
use App\Helpers\NumberHelper;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Livewire\Component;

class MilkReport extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    private $userRepository;
    public $page = 'farmer';
    public $entries = 10;
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $milk_deposit_date, $milk_deposit_time, $milk_type;

    public function updatedEntries()
    {
        $this->resetPage('page');
    }

    // ==========filter=========
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function boot(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function render()
    {
        $milkDeposits = $this->userRepository->getMilkDepositsReports($this->entries, $this->search,$this->milk_deposit_date);
        $milkInfo = $this->userRepository->getTotalIncomeFromMilk($this->entries, $this->search,$this->milk_deposit_date);
        $totalDepositIncome = NumberHelper::toNepaliNumber($milkInfo['totalDepositIncome']);
        $totalDepositedMilk = NumberHelper::toNepaliNumber($milkInfo['totalDepositedMilk']);
        return view('livewire.admin.dairy.milk-report', [
            'milkDeposits' => $milkDeposits,
            'totalDepositIncome' => $totalDepositIncome,
            'totalMilkQuantity' => $totalDepositedMilk
        ]);
    }

    // export pdf
    public function printMilkDepositReport()
    {
        $url = route('admin.milk.report.print', [
            'milk_deposit_date' => $this->milk_deposit_date?$this->milk_deposit_date:'no-date',
            'search' => $this->search ?? null,
        ]);
        $this->dispatch('open-new-tab', url: $url);
    }
}
