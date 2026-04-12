<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MilkDeposit extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['user_id', 'milk_quantity', 'milk_fat', 'milk_snf', 'milk_price_per_ltr', 'per_ltr_commission', 'milk_per_ltr_price_with_commission', 'milk_total_price', 'milk_deposit_date', 'milk_deposit_time', 'milk_type'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }



    // uncomment below code when doing QA
    // public static function boot()
    // {
    //     parent::boot();

    //     // Automatically insert Milk Income when Milk Deposit is created
    //     static::created(function ($milkDeposit) {
    //         MilkIncome::create([
    //             'user_id' => $milkDeposit->user_id,
    //             'milk_deposits_id' => $milkDeposit->id,
    //             'deposit' => $milkDeposit->milk_total_price, // Total price as the deposit
    //         ]);
    //     });
    // }
}
