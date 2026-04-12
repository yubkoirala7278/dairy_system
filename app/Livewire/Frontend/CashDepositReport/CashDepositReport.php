<?php

namespace App\Livewire\Frontend\CashDepositReport;

use App\Helpers\NumberHelper;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use Livewire\Component;
use Livewire\WithPagination;
use Bsdate;

class CashDepositReport extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $page = "pages";
    public $sub_page = "cash_deposit_report";
    public $entries = 10;
    private $transactionRepository;
    public $amount_deposit_date;
    public $amount_deposit_date_ad;

    public function updatedEntries()
    {
        $this->resetPage('page');
    }

    public function boot(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function render()
    {
        if ($this->amount_deposit_date) {
            $nepali_date_in_english = NumberHelper::toEnglishNumber($this->amount_deposit_date);

            // Extract Year, Month, and Day (split using '-')
            list($year, $month, $day) = explode('-', $nepali_date_in_english);

            // Convert BS date to AD
            $converted_date = Bsdate::nep_to_eng((int)$year, (int)$month, (int)$day);
            $this->amount_deposit_date_ad = $converted_date['year'] . '-' . $converted_date['month'] . '-' . $converted_date['date'];
        } else {
            $this->reset('amount_deposit_date_ad');
        }
        $depositTransactions = $this->transactionRepository->depositAuthUserTransactions($this->entries, $this->amount_deposit_date_ad);
        $sumDepositAmount = $this->transactionRepository->AuthUserSumDepositAmount($this->amount_deposit_date_ad);
        return view('livewire.frontend.cash-deposit-report.cash-deposit-report', [
            'depositTransactions' => $depositTransactions,
            'sumDepositAmount' => $sumDepositAmount,
        ]);
    }
}
