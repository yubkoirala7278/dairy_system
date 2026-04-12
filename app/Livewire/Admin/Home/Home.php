<?php

namespace App\Livewire\Admin\Home;

use Livewire\Component;

class Home extends Component
{
    public $page = 'dashboard';
    public function render()
    {
        return view('livewire.admin.home.home');
    }
}
