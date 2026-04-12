<?php

namespace App\Livewire\Admin\Pdf;

use App\Repositories\Interfaces\TransactionRepositoryInterface;
use Livewire\Component;

class DepositTransaction extends Component
{
    private $transactionRepository;
    public $search;
    public $amount_deposit_date;
    public $entries='all';

    public function boot(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }
    public function mount($amount_deposit_date,$search=null){
        $this->search= $search;
        $this->amount_deposit_date=$amount_deposit_date=='no-amount-deposit-date'?null:$amount_deposit_date;
    }
    public function render()
    {
        $depositTransactions = $this->transactionRepository->depositTransactions($this->entries, $this->search,$this->amount_deposit_date);
        $sumDepositAmount = $this->transactionRepository->sumDepositAmount($this->search,$this->amount_deposit_date);
        return view('livewire.admin.pdf.deposit-transaction', [
            'depositTransactions' => $depositTransactions,
            'sumDepositAmount' => $sumDepositAmount
        ]);
    }
}
