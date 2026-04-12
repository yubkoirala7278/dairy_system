<?php

namespace App\Livewire\Frontend\Contact;

use Livewire\Component;

class Contact extends Component
{
    public $page = 'contact';
    public $sub_page;
    public function render()
    {
        return view('livewire.frontend.contact.contact');
    }
}
