<?php

namespace App\Livewire\Admin\Pdf;

use App\Helpers\NumberHelper;
use App\Models\MilkDeposit as ModelsMilkDeposit;
use Livewire\Component;

class MilkDeposit extends Component
{
    public $search, $milk_deposit_date, $milk_deposit_time;

    public function mount($milk_deposit_date = '', $milk_deposit_time = '')
    {
        $this->milk_deposit_date = $milk_deposit_date;
        $this->milk_deposit_time = $milk_deposit_time;
    }

    public function render()
    {
        $milkDepositsInfo = $this->exportToPdf();
        return view('livewire.admin.pdf.milk-deposit', [
            'milkDeposits' => $milkDepositsInfo['milk_deposits'],
            'totalDepositIncome' => $milkDepositsInfo['total_milk_deposits'],
            'totalDepositedMilk' => $milkDepositsInfo['total_milk_price']
        ]);
    }


    public function exportToPdf()
    {
        $milkDeposits = ModelsMilkDeposit::with('user')
            ->where('milk_deposit_date', $this->milk_deposit_date)
            ->where('milk_deposit_time', $this->milk_deposit_time)
            ->join('users', 'users.id', '=', 'milk_deposits.user_id')
            ->orderBy('users.id', 'asc')
            ->get();
        if (count($milkDeposits) <= 0) {
            $this->dispatch('warningMessage', title: 'डाउनलोड गर्नको लागि कुनै दूध जम्मा उपलब्ध छैन!');
            return [
                'milk_deposits' => [],
                'total_milk_deposits' => 0,
                'total_milk_price' => 0
            ];
        }

        $milkDeposits->transform(function ($deposit) {
            $deposit->milk_per_ltr_price_with_commission = NumberHelper::toNepaliNumber($deposit->milk_per_ltr_price_with_commission);
            $deposit->milk_snf = NumberHelper::toNepaliNumber($deposit->milk_snf);
            $deposit->milk_fat = NumberHelper::toNepaliNumber($deposit->milk_fat);
            $deposit->milk_quantity = NumberHelper::toNepaliNumber($deposit->milk_quantity);
            $deposit->milk_total_price = NumberHelper::toNepaliNumber($deposit->milk_total_price);

            return $deposit;
        });
        // Retrieve the sum of both milk_quantity and milk_total_price in a single query
        $totals = ModelsMilkDeposit::where('milk_deposit_date', $this->milk_deposit_date)
            ->where('milk_deposit_time', $this->milk_deposit_time)
            ->selectRaw('sum(milk_quantity) as total_milk_deposits, sum(milk_total_price) as total_milk_price')
            ->first();

        // Convert the totals to Nepali numbers
        $total_milk_deposits = NumberHelper::toNepaliNumber($totals->total_milk_deposits);
        $total_milk_price = NumberHelper::toNepaliNumber($totals->total_milk_price);

        if (!$milkDeposits) {
            $this->dispatch('error', title: 'डाउनलोड गर्नको लागि कुनै दूध जम्मा छैन!');
            return;
        }
        return [
            'milk_deposits' => $milkDeposits,
            'total_milk_deposits' => $total_milk_deposits,
            'total_milk_price' => $total_milk_price
        ];
    }
}
