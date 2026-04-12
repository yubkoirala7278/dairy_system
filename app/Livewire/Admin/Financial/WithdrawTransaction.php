<?php

namespace App\Livewire\Admin\Financial;

use App\Exports\WithdrawTransactionExport;
use App\Helpers\NumberHelper;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use Livewire\Component;
use Livewire\WithPagination;
use Bsdate;
use Maatwebsite\Excel\Facades\Excel;


class WithdrawTransaction extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $page = 'financial';
    private $transactionRepository;
    public $entries = 10;
    public $search = '';
    public $amount_withdraw_date;
    public $amount_withdraw_date_ad;

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
    public function updatingAmountWithdrawDate()
    {
        $this->resetPage();
    }

    public function render()
    {
        if ($this->amount_withdraw_date) {
            $nepali_date_in_english = NumberHelper::toEnglishNumber($this->amount_withdraw_date);

            // Extract Year, Month, and Day (split using '-')
            list($year, $month, $day) = explode('-', $nepali_date_in_english);

            // Convert BS date to AD
            $converted_date = Bsdate::nep_to_eng((int)$year, (int)$month, (int)$day);
            $this->amount_withdraw_date_ad = $converted_date['year'] . '-' . $converted_date['month'] . '-' . $converted_date['date'];
        } else {
            $this->reset('amount_withdraw_date_ad');
        }
        $withdrawTransactions = $this->transactionRepository->withdrawTransactions($this->entries, $this->search, $this->amount_withdraw_date_ad);
        $sumWithdrawAmount = $this->transactionRepository->sumWithdrawAmount($this->search, $this->amount_withdraw_date_ad);
        return view('livewire.admin.financial.withdraw-transaction', [
            'withdrawTransactions' => $withdrawTransactions,
            'sumWithdrawAmount' => $sumWithdrawAmount,
        ]);
    }

    // export to excel
    public function exportToExcel()
    {
        $withdrawTransactions = $this->transactionRepository->withdrawTransactions('all', $this->search, $this->amount_withdraw_date_ad);

        if ($withdrawTransactions->isEmpty()) {
            $this->dispatch('warningMessage', title: 'डाउनलोड गर्न मिल्ने कुनै कृषकको वित्तीय विवरण रिपोर्ट उपलब्ध छैन।');
            return;
        }
        $sumWithdrawAmount = $this->transactionRepository->sumWithdrawAmount($this->search, $this->amount_withdraw_date_ad);

        // Pass the data to the TransactionExport class
        return Excel::download(new WithdrawTransactionExport($withdrawTransactions, $sumWithdrawAmount), 'withdraw_transaction.xlsx');
    }
    // export pdf
    public function printWithdrawTransaction()
    {
        $url = route('admin.withdraw.transaction.report.print', [
            'amount_withdraw_date' => $this->amount_withdraw_date_ad ? $this->amount_withdraw_date_ad : 'no-amount-withdraw-date',
            'search' => $this->search ? $this->search : '',
        ]);
        $this->dispatch('open-new-tab', url: $url);
    }
}
