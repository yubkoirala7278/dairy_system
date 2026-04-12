<?php

namespace App\Livewire\Frontend\Profile;

use App\Helpers\NumberHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Profile extends Component
{
    public $page = 'profile';
    public $sub_page;
    public $old_password, $new_password, $new_password_confirmation;

    public function render()
    {
        $user_balance = NumberHelper::toNepaliNumber(Auth::user()->account->balance);
        return view('livewire.frontend.profile.profile', [
            'user_balance' => $user_balance
        ]);
    }

    public function changePassword()
    {
        // Validate the inputs with custom Nepali error messages.
        $this->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed', // 'confirmed' ensures both passwords match
        ], [
            'old_password.required' => 'हालको पासवर्ड आवश्यक छ।',
            'new_password.required' => 'नयाँ पासवर्ड आवश्यक छ।',
            'new_password.min'      => 'नयाँ पासवर्ड कम्तिमा :min अक्षर लामो हुनुपर्छ।',
            'new_password.confirmed' => 'नयाँ पासवर्ड र पुष्टि पासवर्ड मिलेन।', // Password confirmation error message
        ]);

        // Check if the provided current password matches the logged-in user's password.
        if (!Hash::check($this->old_password, Auth::user()->password)) {
            $this->addError('old_password', 'हालको पासवर्ड मिलेन।');
            return;
        }

        // Update the user's password.
        $user = Auth::user();
        $user->password = Hash::make($this->new_password);
        $user->save();

        // Reset the form fields.
        $this->reset();

        // Flash a success message.
        $this->dispatch('success', title: 'पासवर्ड सफलतापूर्वक परिवर्तन गरियो।');
    }
}
