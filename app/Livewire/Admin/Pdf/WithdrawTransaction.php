<?php

namespace App\Livewire\Admin\Pdf;

use App\Repositories\Interfaces\TransactionRepositoryInterface;
use Livewire\Component;

class WithdrawTransaction extends Component
{
    private $transactionRepository;
    public $search;
    public $amount_withdraw_date;
    public $entries='all';

    public function boot(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }
    public function mount($amount_withdraw_date,$search=null){
        $this->search= $search;
        $this->amount_withdraw_date=$amount_withdraw_date=='no-amount-withdraw-date'?null:$amount_withdraw_date;
    }
    public function render()
    {
        $withdrawTransactions = $this->transactionRepository->withdrawTransactions($this->entries, $this->search,$this->amount_withdraw_date);
        $sumWithdrawAmount = $this->transactionRepository->sumWithdrawAmount($this->search,$this->amount_withdraw_date);
        return view('livewire.admin.pdf.withdraw-transaction', [
            'withdrawTransactions' => $withdrawTransactions,
            'sumWithdrawAmount' => $sumWithdrawAmount
        ]);
    }
}
