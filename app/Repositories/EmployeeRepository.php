<?php

namespace App\Repositories;

use App\Helpers\NumberHelper;
use App\Models\Administrator;
use App\Models\Employee;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    // fetch all employee
    public function all($entries, $search)
    {
        $query = Employee::query();

        // Apply search filter
        if (!empty($search)) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('position', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%")
                ->orWhere('gender', 'like', "%{$search}%");
        }

        // Paginate based on the number of entries per page
        $employees = $query->orderBy('rank', 'asc')->paginate($entries);

        // Convert rank to Nepali number
        foreach ($employees as $key => $employee) {
            $employee->rank = NumberHelper::toNepaliNumber($employee->rank);
            $employee->sn = NumberHelper::toNepaliNumber($key + 1);
        }

        return $employees;
    }

    // fetch all administrator
    public function allAdministrators($entries, $search)
    {
        $query = Administrator::query();

        // Apply search filter
        if (!empty($search)) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('position', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%")
                ->orWhere('gender', 'like', "%{$search}%");
        }

        // Paginate based on the number of entries per page
        $administrators = $query->orderBy('rank', 'asc')->paginate($entries);

        // Convert rank to Nepali number
        foreach ($administrators as $key => $administrator) {
            $administrator->rank = NumberHelper::toNepaliNumber($administrator->rank);
            $administrator->sn = NumberHelper::toNepaliNumber($key + 1);
        }

        return $administrators;
    }
}
