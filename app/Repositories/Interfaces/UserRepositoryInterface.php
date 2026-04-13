<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function all($entries, $search);
    public function getMilkDeposits($entries, $search,$milk_deposit_date,$milk_deposit_time,$milk_type,$is_pdf = null,$sortBy = null,$sortDirection = 'asc');
    public function getTotalIncomeFromMilkOnSpecificDate($milk_deposit_date, $milk_deposit_time);
    public function getMilkDepositsReports($entries = 10, $search = null, $milk_deposit_date_from = null, $milk_deposit_date_to = null);
    public function getTotalIncomeFromMilk($entries = 10, $search = null, $milk_deposit_date_from = null, $milk_deposit_date_to = null);
    public function getAuthUserMilkDepositsReports($entries = 10, $search = null, $milk_deposit_date = null);
    public function getAuthUserTotalIncomeFromMilk($entries = 10, $search = null, $milk_deposit_date = null);
}
