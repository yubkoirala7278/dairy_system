<?php

namespace App\Livewire\Frontend\MilkDepositReport;

use App\Helpers\NumberHelper;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Livewire\Component;
use Livewire\WithPagination;

class MilkDepositReport extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    private $userRepository;
    public $page="pages";
    public $sub_page="milk_deposit_report";
    public $entries = 10;
    public $search = '';
    public $milk_deposit_date;

    public function updatedEntries()
    {
        $this->resetPage('page');
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
        $milkDeposits = $this->userRepository->getAuthUserMilkDepositsReports($this->entries, $this->search,$this->milk_deposit_date);
        $milkInfo = $this->userRepository->getAuthUserTotalIncomeFromMilk($this->entries, $this->search,$this->milk_deposit_date);
        $totalDepositIncome = NumberHelper::toNepaliNumber($milkInfo['totalDepositIncome']);
        $totalDepositedMilk = NumberHelper::toNepaliNumber($milkInfo['totalDepositedMilk']);
        return view('livewire.frontend.milk-deposit-report.milk-deposit-report',[
            'milkDeposits' => $milkDeposits,
            'totalDepositIncome' => $totalDepositIncome,
            'totalMilkQuantity' => $totalDepositedMilk
        ]);
    }
}
