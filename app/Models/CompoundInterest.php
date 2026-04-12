<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompoundInterest extends Model
{
    use HasFactory;
    protected $fillable=['account_id','interest_amount','period'];
}
