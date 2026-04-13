<?php

namespace App\Livewire\Admin\Home;

use App\Helpers\NumberHelper;
use App\Models\Account;
use App\Models\Employee;
use App\Models\MilkDeposit;
use App\Models\MilkIncome;
use App\Models\Transaction;
use App\Models\User;
use Livewire\Component;

class Home extends Component
{
    public $page = 'dashboard';

    public function render()
    {
        // Card stats
        $totalFarmers = User::role('farmer')->count();
        $activeFarmers = User::role('farmer')->where('status', 'चालू')->count();
        $inactiveFarmers = User::role('farmer')->where('status', 'बन्द')->count();
        $totalEmployees = Employee::count();

        $totalMilkCollected = MilkDeposit::sum('milk_quantity');
        $totalMilkIncome = MilkDeposit::sum('milk_total_price');
        $totalAccountBalance = Account::sum('balance');
        $totalDeposits = Transaction::where('type', 'deposit')->sum('amount');
        $totalWithdrawals = Transaction::where('type', 'withdrawal')->sum('amount');

        // Gender distribution for pie chart
        $maleCount = User::role('farmer')->where('gender', 'पुरुष')->count();
        $femaleCount = User::role('farmer')->where('gender', 'महिला')->count();
        $otherCount = User::role('farmer')->where('gender', 'अन्य')->count();

        // Last 10 unique deposit dates for line chart (milk collection trend)
        $recentDates = MilkDeposit::select('milk_deposit_date')
            ->distinct()
            ->orderBy('milk_deposit_date', 'desc')
            ->limit(10)
            ->pluck('milk_deposit_date')
            ->reverse()
            ->values();

        $dailyMilkQuantities = [];
        $dailyMilkIncome = [];
        foreach ($recentDates as $date) {
            $dailyMilkQuantities[] = round((float) MilkDeposit::where('milk_deposit_date', $date)->sum('milk_quantity'), 2);
            $dailyMilkIncome[] = round((float) MilkDeposit::where('milk_deposit_date', $date)->sum('milk_total_price'), 2);
        }

        // Morning vs Evening milk collection for bar chart
        $morningMilk = round((float) MilkDeposit::where('milk_deposit_time', 'बिहान')->sum('milk_quantity'), 2);
        $eveningMilk = round((float) MilkDeposit::where('milk_deposit_time', 'साझ')->sum('milk_quantity'), 2);
        $morningIncome = round((float) MilkDeposit::where('milk_deposit_time', 'बिहान')->sum('milk_total_price'), 2);
        $eveningIncome = round((float) MilkDeposit::where('milk_deposit_time', 'साझ')->sum('milk_total_price'), 2);

        // Top 5 farmers by milk quantity
        $topFarmers = MilkDeposit::select('user_id')
            ->selectRaw('SUM(milk_quantity) as total_milk')
            ->selectRaw('SUM(milk_total_price) as total_income')
            ->groupBy('user_id')
            ->orderByDesc('total_milk')
            ->limit(5)
            ->with('user')
            ->get();

        // Transaction trend (deposits vs withdrawals) - last 10 dates
        $recentTransactions = Transaction::selectRaw('DATE(created_at) as tx_date')
            ->distinct()
            ->orderBy('tx_date', 'desc')
            ->limit(10)
            ->pluck('tx_date')
            ->reverse()
            ->values();

        $dailyDeposits = [];
        $dailyWithdrawals = [];
        foreach ($recentTransactions as $date) {
            $dailyDeposits[] = round((float) Transaction::where('type', 'deposit')->whereDate('created_at', $date)->sum('amount'), 2);
            $dailyWithdrawals[] = round((float) Transaction::where('type', 'withdrawal')->whereDate('created_at', $date)->sum('amount'), 2);
        }

        return view('livewire.admin.home.home', [
            'totalFarmers' => $totalFarmers,
            'activeFarmers' => $activeFarmers,
            'inactiveFarmers' => $inactiveFarmers,
            'totalEmployees' => $totalEmployees,
            'totalMilkCollected' => NumberHelper::toNepaliNumber($totalMilkCollected),
            'totalMilkIncome' => NumberHelper::toNepaliNumber($totalMilkIncome),
            'totalAccountBalance' => NumberHelper::toNepaliNumber($totalAccountBalance),
            'totalDeposits' => NumberHelper::toNepaliNumber($totalDeposits),
            'totalWithdrawals' => NumberHelper::toNepaliNumber($totalWithdrawals),
            'maleCount' => $maleCount,
            'femaleCount' => $femaleCount,
            'otherCount' => $otherCount,
            'recentDates' => $recentDates,
            'dailyMilkQuantities' => $dailyMilkQuantities,
            'dailyMilkIncome' => $dailyMilkIncome,
            'morningMilk' => $morningMilk,
            'eveningMilk' => $eveningMilk,
            'morningIncome' => $morningIncome,
            'eveningIncome' => $eveningIncome,
            'topFarmers' => $topFarmers,
            'recentTransactions' => $recentTransactions,
            'dailyDeposits' => $dailyDeposits,
            'dailyWithdrawals' => $dailyWithdrawals,
        ]);
    }
}
