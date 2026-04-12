<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'price_per_kg', 'status', 'image','unit'];
    // Mutator to automatically generate slug
    public static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            // Generate a random slug
            $slug = Str::random(8); // Adjust length if needed

            // Ensure slug is unique
            while (Product::where('slug', $slug)->exists()) {
                $slug = Str::random(8); // Regenerate if slug exists
            }

            $product->slug = $slug;
        });
    }
}
