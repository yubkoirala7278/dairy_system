<?php

namespace App\Livewire\Frontend;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Redirect;

class LogoutButton extends Component
{
    public function logout()
    {
        // Log the user out
        Auth::logout();

        // Redirect to the homepage (/)
        return Redirect::to('/');
    }

    public function render()
    {
        return view('livewire.frontend.logout-button');
    }
}
