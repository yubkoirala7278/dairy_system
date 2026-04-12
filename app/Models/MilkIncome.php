<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MilkIncome extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=['user_id','milk_deposits_id','deposit'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function milkDeposits(){
        return $this->belongsTo(MilkDeposit::class);
    }
}
