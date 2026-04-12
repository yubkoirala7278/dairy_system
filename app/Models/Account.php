<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $fillable=['user_id','balance','interest_rate','last_interest_calculation_date'];
    // Relationship with user
    public function user(){
        return $this->belongsTo(User::class);
    }
}
