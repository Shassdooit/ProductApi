<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = [
        'title',
        'image',
        'description',
        'price',
    ];

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'orders_products');
    }

    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class, 'carts_products', 'product_id', 'cart_id')
            ->withPivot('quantity')
            ->withTimestamps();
    }

}
