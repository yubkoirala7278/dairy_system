<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/home'; // Default redirection

    /**
     * Handle login request with farmer_number and password validation.
     */
    public function login(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'farmer_number' => 'required|string',
            'password' => 'required',
        ], [
            'farmer_number.required' => 'किसान नम्बर आवश्यक छ।',
            'farmer_number.string' => 'किसान नम्बर केवल अङ्क र अक्षर हुनुपर्छ।',
            'password.required' => 'पासवर्ड आवश्यक छ।',
        ]);

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Attempt login with farmer_number and password
        if (Auth::attempt(['farmer_number' => $request->farmer_number, 'password' => $request->password], $request->remember)) {
            // Redirect based on role after successful login
            return $this->authenticated($request, Auth::user());
        }

        // If login fails, redirect back with error
        return redirect()->back()->with('error', 'कृपया सही किसान नम्बर वा पासवर्ड प्रविष्ट गर्नुहोस्।');
    }

    /**
     * Handle post-login redirection based on user roles.
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->hasRole('farmer')) {
            return redirect()->route('frontend.home');
        }

        if ($user->hasAnyRole(['admin', 'dairy_manager', 'financial_manager'])) {
            return redirect()->route('admin.home');
        }

        // Default redirection for other cases
        return redirect()->route('login')->with('error', 'Unauthorized role.');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
