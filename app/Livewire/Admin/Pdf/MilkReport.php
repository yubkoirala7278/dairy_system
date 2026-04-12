<?php

namespace App\Livewire\Admin\Pdf;

use App\Helpers\NumberHelper;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Livewire\Component;

class MilkReport extends Component
{
    public $milk_deposit_date, $search;
    private $userRepository;
    public $entries = 100000000000;
    public function mount($milk_deposit_date = '', $search = '')
    {
        $this->milk_deposit_date = $milk_deposit_date == 'no-date' ? null : $milk_deposit_date;
        $this->search = $search;
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
        return view('livewire.admin.pdf.milk-report', [
            'milkDeposits' => $milkDeposits,
            'totalDepositIncome' => $totalDepositIncome,
            'totalMilkQuantity' => $totalDepositedMilk
        ]);
    }
  
}
