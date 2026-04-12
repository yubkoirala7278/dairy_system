<?php

namespace App\Livewire\Frontend\Gallery;

use Livewire\Component;

class Gallery extends Component
{
    public $page="pages";
    public $sub_page="gallery";
    public function render()
    {
        return view('livewire.frontend.gallery.gallery');
    }
}
