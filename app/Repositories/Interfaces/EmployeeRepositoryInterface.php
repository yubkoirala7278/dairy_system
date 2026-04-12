<?php

namespace App\Repositories\Interfaces;

interface EmployeeRepositoryInterface
{
    public function all($entries, $search);
    public function allAdministrators($entries, $search);
}
