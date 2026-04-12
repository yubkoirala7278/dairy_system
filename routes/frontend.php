<?php

use App\Livewire\Frontend\Cart\Cart;
use App\Livewire\Frontend\CashDepositReport\CashDepositReport;
use App\Livewire\Frontend\CashWithdrawReport\CashWithdrawReport;
use App\Livewire\Frontend\Checkout\Checkout;
use App\Livewire\Frontend\Checkout\CheckoutSuccess;
use App\Livewire\Frontend\Contact\Contact;
use App\Livewire\Frontend\Gallery\Gallery;
use App\Livewire\Frontend\Home\Home;
use App\Livewire\Frontend\MilkDepositReport\MilkDepositReport;
use App\Livewire\Frontend\Order\Order;
use App\Livewire\Frontend\Order\OrderDetail;
use App\Livewire\Frontend\Product\Product;
use App\Livewire\Frontend\Profile\Profile;
use App\Livewire\Frontend\Service\Service;
use App\Livewire\Frontend\Team\Team;
use Illuminate\Support\Facades\Route;

// Define the home route for frontend
Route::get('/home', Home::class)->name('home');
Route::get('/service', Service::class)->name('service');
Route::get('/product', Product::class)->name('product');
Route::get('/gallery', Gallery::class)->name('gallery');
Route::get('/team', Team::class)->name('team');
Route::get('/contact-us', Contact::class)->name('contact');
Route::get('/cart', Cart::class)->name('cart');
Route::get('/checkout', Checkout::class)->name('checkout');
Route::get('/checkout-success', CheckoutSuccess::class)->name('checkout.success');
Route::get('/profile', Profile::class)->name('profile');
Route::get('/my-order',Order::class)->name('my-order');
Route::get('/my-order-details/{slug}',OrderDetail::class)->name('my-order-details');
Route::get('/milk_deposit_report',MilkDepositReport::class)->name('my-milk-deposit-reports');
Route::get('/cash_deposit_report',CashDepositReport::class)->name('my-cash-deposit-reports');
Route::get('/cash_withdraw_report',CashWithdrawReport::class)->name('my-cash-withdraw-reports');
