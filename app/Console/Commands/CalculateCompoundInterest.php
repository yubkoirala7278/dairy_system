<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Account;
use App\Models\CompoundInterest;
use Carbon\Carbon;

class CalculateCompoundInterest extends Command
{
    protected $signature = 'calculate:compound-interest';
    protected $description = 'Calculate compound interest for all accounts';

    public function handle()
    {
        $accounts = Account::all();
        $currentDate = Carbon::now()->toDateString();

        foreach ($accounts as $account) {
            $lastCalculationDate = $account->last_interest_calculation_date 
                ? Carbon::parse($account->last_interest_calculation_date) 
                : null;

            if (!$lastCalculationDate || $lastCalculationDate->lt(Carbon::now())) {
                $daysSinceLast = $lastCalculationDate 
                    ? Carbon::now()->diffInDays($lastCalculationDate) 
                    : 1;

                $interest = $account->balance * pow((1 + ($account->interest_rate / 100) / 365), $daysSinceLast) - $account->balance;

                if ($interest > 0) {
                    $account->increment('balance', $interest);
                    $account->update(['last_interest_calculation_date' => $currentDate]);

                    CompoundInterest::create([
                        'account_id' => $account->id,
                        'interest_amount' => $interest,
                        'period' => $currentDate,
                    ]);
                }
            }
        }

        $this->info('Compound interest calculated for all accounts.');
    }
}
