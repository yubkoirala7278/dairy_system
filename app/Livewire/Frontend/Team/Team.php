<?php

namespace App\Livewire\Frontend\Team;

use App\Models\Employee;
use App\Models\Administrator;
use Livewire\Component;

class Team extends Component
{
    public $page="pages";
    public $sub_page="team";
    public function render()
    {
        $employees=Employee::orderBy('rank', 'asc')->get();
        $administrations=Administrator::orderBy('rank', 'asc')->get();
        return view('livewire.frontend.team.team',[
            'employees'=>$employees,
            'administrations'=>$administrations
        ]);
    }
}
