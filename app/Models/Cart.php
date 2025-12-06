<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'meal_id',
        'quantity',
        'price',
    ];

    /**
     * Get the meal associated with the cart item.
     */
    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }

    /**
     * Get the user associated with the cart.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get subtotal for this cart item
     */
    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->price;
    }
}
