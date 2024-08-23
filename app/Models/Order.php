<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * @method static findOrFail($orderId)
 */
class Order extends Model
{
    use HasFactory;

    protected array $enumCasts = [
        'status' => OrderStatusEnum::class,
    ];
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'phone',
        'status',
        'total',
    ];

    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
