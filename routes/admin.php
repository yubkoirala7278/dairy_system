<?php

use App\Livewire\Admin\Administrator\Administrator;
use App\Livewire\Admin\Dairy\Accounting;
use App\Livewire\Admin\Dairy\CreateUser;
use App\Livewire\Admin\Dairy\MilkDeposit;
use App\Livewire\Admin\Dairy\MilkReport;
use App\Livewire\Admin\Dairy\Setup;
use App\Livewire\Admin\Employee\Employee;
use App\Livewire\Admin\Financial\DepositTransaction;
use App\Livewire\Admin\Financial\Transaction;
use App\Livewire\Admin\Financial\WithdrawTransaction;
use App\Livewire\Admin\Home\Home;
use App\Livewire\Admin\Pdf\Accounting as PdfAccounting;
use App\Livewire\Admin\Pdf\DepositTransaction as PdfDepositTransaction;
use App\Livewire\Admin\Pdf\MilkDeposit as PdfMilkDeposit;
use App\Livewire\Admin\Pdf\MilkReport as PdfMilkReport;
use App\Livewire\Admin\Pdf\PrintUsers;
use App\Livewire\Admin\Pdf\Transaction as PdfTransaction;
use App\Livewire\Admin\Pdf\WithdrawTransaction as PdfWithdrawTransaction;
use App\Livewire\Admin\Product\Order;
use App\Livewire\Admin\Product\Product;
use Illuminate\Support\Facades\Route;

Route::get('/home', Home::class)->name('home');
Route::get('/farmer/create', CreateUser::class)->name('farmer.create');
Route::get('/farmer/milk/deposit', MilkDeposit::class)->name('farmer.milk.deposit');
Route::get('/setup', Setup::class)->name('setup');
Route::get('/milk-deposit-report',MilkReport::class)->name('milk.deposit.report');
Route::get('/product',Product::class)->name('product');
Route::get('/orders',Order::class)->name('order');
Route::get('/transaction',Transaction::class)->name('transaction');
Route::get('/deposit-transaction',DepositTransaction::class)->name('deposit.transaction');
Route::get('/milk-deposit-income',Accounting::class)->name('accounting');
Route::get('/withdraw-transaction',WithdrawTransaction::class)->name('withdraw.transaction');
Route::get('/employee',Employee::class)->name('employee');
Route::get('/administration',Administrator::class)->name('administration');


// print
Route::get('/users/print/{search?}', PrintUsers::class)->name('users.print');
Route::get('/milk-deposit/print/{milk_deposit_date}/{milk_deposit_time}/{search?}', PdfMilkDeposit::class)->name('milk.deposit.print');
Route::get('/accounting/print/{milk_deposit_date}/{search?}', PdfAccounting::class)->name('accounting.print');
Route::get('/milk-deposit-report/print/{milk_deposit_date}/{search?}', PdfMilkReport::class)->name('milk.report.print');
Route::get('/transaction-report/print', PdfTransaction::class)->name('transaction.report.print');
Route::get('/deposit-transaction-report/print/{amount_deposit_date}/{search?}', PdfDepositTransaction::class)->name('deposit.transaction.report.print');
Route::get('/withdraw-transaction-report/print/{amount_withdraw_date}/{search?}', PdfWithdrawTransaction::class)->name('withdraw.transaction.report.print');
