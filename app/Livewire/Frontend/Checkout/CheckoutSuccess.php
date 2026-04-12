<?php

namespace App\Livewire\Frontend\Checkout;

use Livewire\Component;

class CheckoutSuccess extends Component
{
    public $page = 'cart';
    public $sub_page;
    
    public function render()
    {
        return view('livewire.frontend.checkout.checkout-success');
    }
}
