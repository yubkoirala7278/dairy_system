<?php

namespace App\Livewire\Frontend\CashWithdrawReport;

use App\Helpers\NumberHelper;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use Livewire\Component;
use Livewire\WithPagination;
use Bsdate;

class CashWithdrawReport extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $page = "pages";
    public $sub_page = "cash_withdraw_report";
    private $transactionRepository;
    public $entries = 10;
    public $amount_withdraw_date;
    public $amount_withdraw_date_ad;

    public function updatedEntries()
    {
        $this->resetPage('page');
    }
   
    public function updatingAmountWithdrawDate()
    {
        $this->resetPage();
    }

    public function boot(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
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
        $withdrawTransactions = $this->transactionRepository->withdrawAuthUserTransactions($this->entries, $this->amount_withdraw_date_ad);
        $sumWithdrawAmount = $this->transactionRepository->sumAuthWithdrawAmount($this->amount_withdraw_date_ad);
        return view('livewire.frontend.cash-withdraw-report.cash-withdraw-report', [
            'withdrawTransactions' => $withdrawTransactions,
            'sumWithdrawAmount' => $sumWithdrawAmount,
        ]);
    }
}
