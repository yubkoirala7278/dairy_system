<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Helpers\NumberHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'owner_name',
        'farmer_number',
        'location',
        'gender',
        'status',
        'phone_number',
        'pan_number',
        'vat_number',
        'slug',
        'milk_snf',
        'milk_fat'
    ];
    // Boot method to hook into the model's lifecycle
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->slug = static::generateUniqueSlug($user->name);
        });
    }

    // Method to generate unique slug
    public static function generateUniqueSlug($name)
    {
        // Get current date in 'Y-m-d' format
        $date = now()->format('Y-m-d');

        // Generate a slug from the user's name
        $slug = Str::slug($name) . '-' . $date;

        // Check if the slug already exists in the database
        $existingSlugCount = static::where('slug', $slug)->count();

        // If it exists, append a number to make it unique
        if ($existingSlugCount > 0) {
            $slug = "{$slug}-" . ($existingSlugCount + 1);
        }

        return $slug;
    }

    public function getRemainingBalanceAttribute()
    {
        // Ensure that if no deposit or withdraw is made, return 0
        $totalDeposit = $this->deposit_sum_deposit ?? 0;
        $totalWithdraw = $this->withdraw_sum_withdraw ?? 0;
        $remainingBalance = $totalDeposit - $totalWithdraw;

        // Convert the remaining balance to Nepali number format
        $remainingBalanceNepali = NumberHelper::toNepaliNumber($remainingBalance);

        // Return both English and Nepali numbers in an array
        return [
            'english' => $remainingBalance,
            'nepali'  => $remainingBalanceNepali,
        ];
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    // Relationship with account
    public function account()
    {
        return $this->hasOne(Account::class);
    }
}
