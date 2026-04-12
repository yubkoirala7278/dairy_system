<?php

namespace App\Livewire\Admin\Pdf;

use App\Repositories\Interfaces\TransactionRepositoryInterface;
use Livewire\Component;

class Accounting extends Component
{
    public $milk_deposit_date, $search;
    private $transactionRepository;
    public $entries = 1000000;
    public function mount($milk_deposit_date = '', $search = '')
    {
        $this->milk_deposit_date = $milk_deposit_date == 'no-date' ? null : $milk_deposit_date;
        $this->search = $search;
    }
    public function boot(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }
    public function render()
    {
        $milkDepositsIncome = $this->transactionRepository->getMilkDepositIncome($this->entries, $this->search, $this->milk_deposit_date);
        $totals = $this->transactionRepository->getTotalMilkIncomeWithFilters($this->search, $this->milk_deposit_date);
        return view('livewire.admin.pdf.accounting', [
            'milkDepositsIncome' => $milkDepositsIncome,
            'totalMilkQuantity' => $totals['total_milk_quantity_nepali'],
            'totalMilkTotalPrice' =>  $totals['total_milk_price_nepali'],
        ]);
    }
}
