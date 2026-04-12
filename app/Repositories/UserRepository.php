<?php

namespace App\Repositories;

use App\Models\MilkDeposit;
use App\Models\User;
use Carbon\Carbon;
use App\Helpers\NumberHelper;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface
{
    public function all($entries, $search, $order = null)
    {
        // Start the query with users who have the 'farmer' role
        $query = User::role('farmer');

        // Apply search filter if search term is provided
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->Where('owner_name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('farmer_number', '=', $search)
                    ->orWhere('gender', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }

        // Apply sorting logic
        if (!empty($order) && strtolower($order) === 'asc') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->latest();
        }

        // Paginate the results
        if ($entries == 'all') {
            return $query->get();
        }
        return $query->paginate($entries);
    }

    // ============get milk deposits =================
    public function getMilkDeposits($entries = 10, $search = null, $milk_deposit_date = null, $milk_deposit_time = null, $milk_type = null, $is_pdf = null)
    {
        // Start the query
        $query = MilkDeposit::with('user');

        $query->where('milk_deposit_date', $milk_deposit_date);

        // Filter by milk deposit time if provided
        if ($milk_deposit_time) {
            $query->where('milk_deposit_time', $milk_deposit_time);
        }

        // Apply search filter for specific fields
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('farmer_number', '=', $search)
                        ->orWhere('owner_name', 'like', "%{$search}%");
                })
                    ->orWhere('milk_type', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        if (!$is_pdf) {
            $query->latest();
        }

        // Paginate the results with the specified number of entries per page
        if ($entries == 'all') {
            // If 'all' is passed, get all results without pagination
            $milkDeposits = $query->get();
        } else {
            // Otherwise, paginate the results
            $milkDeposits = $query->paginate($entries);
        }

        // Convert the milk_price_per_ltr column to Nepali numerals
        // Use the items() method on the paginator to access the collection
        $milkDeposits->getCollection()->transform(function ($deposit) {
            $deposit->milk_per_ltr_price_with_commission = NumberHelper::toNepaliNumber($deposit->milk_per_ltr_price_with_commission);
            $deposit->milk_snf = NumberHelper::toNepaliNumber($deposit->milk_snf);
            $deposit->milk_fat = NumberHelper::toNepaliNumber($deposit->milk_fat);
            $deposit->milk_quantity = NumberHelper::toNepaliNumber($deposit->milk_quantity);
            $deposit->milk_total_price = NumberHelper::toNepaliNumber($deposit->milk_total_price);
            return $deposit;
        });

        return $milkDeposits;
    }
    // ============end of getting milk deposits===========

    // ==========get total money generated from milk on specific date==========
    public function getTotalIncomeFromMilkOnSpecificDate($milk_deposit_date, $milk_deposit_time, $entries = 10, $search = null)
    {
        // If no date is provided, set to current date
        if (!$milk_deposit_date) {
            $milk_deposit_date = Carbon::now();
        }

        // Start the query
        $query = MilkDeposit::where('milk_deposit_date', $milk_deposit_date)
            ->where('milk_deposit_time', $milk_deposit_time);

        // Apply search filter for specific fields
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('farmer_number', '=', $search)
                        ->orWhere('owner_name', 'like', "%{$search}%");
                })
                    ->orWhere('milk_type', 'like', "%{$search}%");
            });
        }

        // Get total deposit income and total deposited milk with filters
        $totalDepositIncome = $query->sum('milk_total_price');
        $totalDepositedMilk = $query->sum('milk_quantity');

        return [
            'totalDepositIncome' => $totalDepositIncome,
            'totalDepositedMilk' => $totalDepositedMilk
        ];
    }

    // ==========end of getting total money generated from milk on specific date==========

    // ============get total milk deposits reports=================
    public function getMilkDepositsReports($entries = 10, $search = null, $milk_deposit_date = null)
    {
        // Start the query
        $query = MilkDeposit::with('user')
            ->join('users', 'milk_deposits.user_id', '=', 'users.id') // Join users table
            ->select('milk_deposits.*') // Select all columns from milk_deposits
            ->orderBy('users.id', 'asc');

        // Apply search filter for specific fields
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('farmer_number', '=', $search)
                        ->orWhere('owner_name', 'like', "%{$search}%");
                })
                    ->orWhere('milk_type', 'like', "%{$search}%")
                    ->orWhere('milk_deposit_time', 'like', "%{$search}%");
            });
        }
        // Apply filter for milk_deposit_date if provided
        if ($milk_deposit_date) {
            $query->where('milk_deposit_date', '=', $milk_deposit_date);
        }

        // Apply sorting to get latest first
        $query->orderBy('created_at', 'desc');

        // Paginate the results with the specified number of entries per page
        if ($entries == 'all') {
            $milkDeposits = $query->get();
        } else {
            $milkDeposits = $query->paginate($entries);
        }

        // Convert the milk_price_per_ltr column to Nepali numerals
        $milkDeposits->getCollection()->transform(function ($deposit) {
            $deposit->milk_per_ltr_price_with_commission = NumberHelper::toNepaliNumber($deposit->milk_per_ltr_price_with_commission);
            $deposit->milk_snf = NumberHelper::toNepaliNumber($deposit->milk_snf);
            $deposit->milk_fat = NumberHelper::toNepaliNumber($deposit->milk_fat);
            $deposit->milk_quantity = NumberHelper::toNepaliNumber($deposit->milk_quantity);
            $deposit->milk_total_price = NumberHelper::toNepaliNumber($deposit->milk_total_price);
            $deposit->milk_price_per_ltr = NumberHelper::toNepaliNumber($deposit->milk_price_per_ltr);
            $deposit->per_ltr_commission = NumberHelper::toNepaliNumber($deposit->per_ltr_commission);
            return $deposit;
        });

        return $milkDeposits;
    }

    //    =========end of getting total milk deposit reports========


    // ==========get total money generated from milk ==========
    public function getTotalIncomeFromMilk($entries = 10, $search = null, $milk_deposit_date = null)
    {
        // Start the query
        $query = MilkDeposit::query();

        // Apply search filter for specific fields
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('farmer_number', '=', $search)
                        ->orWhere('owner_name', 'like', "%{$search}%");
                })
                    ->orWhere('milk_type', 'like', "%{$search}%")
                    ->orWhere('milk_deposit_time', 'like', "%{$search}%");
            });
        }
        // Apply filter for milk_deposit_date if provided
        if ($milk_deposit_date) {
            $query->where('milk_deposit_date', '=', $milk_deposit_date);
        }


        // Get total deposit income and total deposited milk with filters
        $totalDepositIncome = $query->sum('milk_total_price');
        $totalDepositedMilk = $query->sum('milk_quantity');

        return [
            'totalDepositIncome' => $totalDepositIncome,
            'totalDepositedMilk' => $totalDepositedMilk
        ];
    }
    // ==========end of getting total money generated from milk ==========




    // ============get total milk deposits reports of auth user=================
    public function getAuthUserMilkDepositsReports($entries = 10, $search = null, $milk_deposit_date = null)
    {
        // Start the query
        $query = MilkDeposit::where('user_id', Auth::user()->id)->with('user')
            ->join('users', 'milk_deposits.user_id', '=', 'users.id') // Join users table
            ->select('milk_deposits.*') // Select all columns from milk_deposits
            ->orderBy('users.id', 'asc');

        // Apply search filter for specific fields
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('farmer_number', '=', $search)
                        ->orWhere('owner_name', 'like', "%{$search}%");
                })
                    ->orWhere('milk_type', 'like', "%{$search}%")
                    ->orWhere('milk_deposit_time', 'like', "%{$search}%");
            });
        }
        // Apply filter for milk_deposit_date if provided
        if ($milk_deposit_date) {
            $query->where('milk_deposit_date', '=', $milk_deposit_date);
        }

        // Apply sorting to get latest first
        $query->orderBy('created_at', 'desc');

        // Paginate the results with the specified number of entries per page
        if ($entries == 'all') {
            $milkDeposits = $query->get();
        } else {
            $milkDeposits = $query->paginate($entries);
        }

        // Convert the milk_price_per_ltr column to Nepali numerals
        $milkDeposits->getCollection()->transform(function ($deposit) {
            $deposit->milk_per_ltr_price_with_commission = NumberHelper::toNepaliNumber($deposit->milk_per_ltr_price_with_commission);
            $deposit->milk_snf = NumberHelper::toNepaliNumber($deposit->milk_snf);
            $deposit->milk_fat = NumberHelper::toNepaliNumber($deposit->milk_fat);
            $deposit->milk_quantity = NumberHelper::toNepaliNumber($deposit->milk_quantity);
            $deposit->milk_total_price = NumberHelper::toNepaliNumber($deposit->milk_total_price);
            $deposit->milk_price_per_ltr = NumberHelper::toNepaliNumber($deposit->milk_price_per_ltr);
            $deposit->per_ltr_commission = NumberHelper::toNepaliNumber($deposit->per_ltr_commission);
            return $deposit;
        });

        return $milkDeposits;
    }

    // ==========get total money generated from milk of auth user==========
    public function getAuthUserTotalIncomeFromMilk($entries = 10, $search = null, $milk_deposit_date = null)
    {
        // Start the query
        $query = MilkDeposit::where('user_id', Auth::user()->id);

        // Apply search filter for specific fields
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('farmer_number', '=', $search)
                        ->orWhere('owner_name', 'like', "%{$search}%");
                })
                    ->orWhere('milk_type', 'like', "%{$search}%")
                    ->orWhere('milk_deposit_time', 'like', "%{$search}%");
            });
        }
        // Apply filter for milk_deposit_date if provided
        if ($milk_deposit_date) {
            $query->where('milk_deposit_date', '=', $milk_deposit_date);
        }


        // Get total deposit income and total deposited milk with filters
        $totalDepositIncome = $query->sum('milk_total_price');
        $totalDepositedMilk = $query->sum('milk_quantity');

        return [
            'totalDepositIncome' => $totalDepositIncome,
            'totalDepositedMilk' => $totalDepositedMilk
        ];
    }
    // ==========end of getting total money generated from milk ==========
}
