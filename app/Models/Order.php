<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'user_id',
        'sub_total',
        'total_charge',
        'payment_status',
        'status',
        'shipped_date',
        'shipping_charge'
    ];

    // Boot method to generate a unique slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->slug = self::generateUniqueSlug();
        });
    }

    // Generate a unique 8-character slug
    private static function generateUniqueSlug()
    {
        do {
            $slug = Str::upper(Str::random(8)); // Generate random 8-character slug
        } while (self::where('slug', $slug)->exists()); // Ensure uniqueness

        return $slug;
    }

    // Relationship with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with order items
    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
