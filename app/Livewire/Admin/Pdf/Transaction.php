<?php

namespace App\Livewire\Admin\Pdf;

use App\Repositories\Interfaces\TransactionRepositoryInterface;
use Livewire\Component;

class Transaction extends Component
{
    private $transactionRepository;

    public function boot(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }
    public function render()
    {
        $usersWithTransaction = $this->transactionRepository->getUsersTransactionInfo('all');
        $totalBalance=$this->transactionRepository->getTotalBalance();
        return view('livewire.admin.pdf.transaction',[
            'usersWithTransaction' => $usersWithTransaction,
            'totalBalance'=>$totalBalance
        ]);
    }
}
