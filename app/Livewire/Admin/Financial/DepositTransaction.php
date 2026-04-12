<?php

namespace App\Livewire\Admin\Financial;

use App\Exports\DepositTransactionExport;
use App\Helpers\NumberHelper;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithPagination;
use Bsdate;

class DepositTransaction extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $page = 'financial';
    private $transactionRepository;
    public $entries = 10;
    public $search = '';
    public $amount_deposit_date;
    public $amount_deposit_date_ad;

    public function boot(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function updatedEntries()
    {
        $this->resetPage('page');
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingAmountDepositDate(){
       $this->resetPage();
    }

    public function render()
    {
        if ($this->amount_deposit_date) {
            $nepali_date_in_english = NumberHelper::toEnglishNumber($this->amount_deposit_date);

            // Extract Year, Month, and Day (split using '-')
            list($year, $month, $day) = explode('-', $nepali_date_in_english);

            // Convert BS date to AD
            $converted_date = Bsdate::nep_to_eng((int)$year, (int)$month, (int)$day);
            $this->amount_deposit_date_ad=$converted_date['year'].'-'.$converted_date['month'].'-'.$converted_date['date'];
        }else{
            $this->reset('amount_deposit_date_ad');
        }
        $depositTransactions = $this->transactionRepository->depositTransactions($this->entries, $this->search,$this->amount_deposit_date_ad);
        $sumDepositAmount = $this->transactionRepository->sumDepositAmount($this->search,$this->amount_deposit_date_ad);
       
        return view('livewire.admin.financial.deposit-transaction', [
            'depositTransactions' => $depositTransactions,
            'sumDepositAmount' => $sumDepositAmount,
        ]);
    }

    // export to excel
    public function exportToExcel()
    {
        $depositTransactions = $this->transactionRepository->depositTransactions('all', $this->search,$this->amount_deposit_date_ad);

        if ($depositTransactions->isEmpty()) {
            $this->dispatch('warningMessage', title: 'डाउनलोड गर्न मिल्ने कुनै कृषकको वित्तीय विवरण रिपोर्ट उपलब्ध छैन।');
            return;
        }
        $sumDepositAmount = $this->transactionRepository->sumDepositAmount($this->search,$this->amount_deposit_date_ad);

        // Pass the data to the DepositTransactionExport class
        return Excel::download(new DepositTransactionExport($depositTransactions, $sumDepositAmount), 'deposit_transaction.xlsx');
    }
    // export pdf
    public function printDepositTransaction()
    {
        $url = route('admin.deposit.transaction.report.print', [
            'amount_deposit_date'=>$this->amount_deposit_date_ad?$this->amount_deposit_date_ad:'no-amount-deposit-date',
            'search' => $this->search ? $this->search : '',
        ]);
        $this->dispatch('open-new-tab', url: $url);
    }
}
