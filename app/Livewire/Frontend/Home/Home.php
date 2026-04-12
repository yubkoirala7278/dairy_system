<?php

namespace App\Livewire\Frontend\Home;

use Livewire\Component;

class Home extends Component
{
    public $page = 'home';
    public $sub_page;
    public function render()
    {
        return view('livewire.frontend.home.home');
    }
}
