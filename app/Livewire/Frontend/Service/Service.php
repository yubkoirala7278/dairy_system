<?php

namespace App\Livewire\Frontend\Service;

use Livewire\Component;

class Service extends Component
{
    public $page = 'service';
    public $sub_page;
    public function render()
    {
        return view('livewire.frontend.service.service');
    }
}
