<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const STATUS_OPEN = 'open';
    const STATUS_CANCELED = 'cancelled';
    const STATUS_COMPLETED = 'completed';

    protected $fillable = [
        'user_id',
        'type',
        'price_per_gram',
        'filled_amount',
        'amount',
        'remaining_amount',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buyTrades()
    {
        return $this->hasMany(Trade::class, 'buy_order_id');
    }

    public function sellTrades()
    {
        return $this->hasMany(Trade::class, 'sell_order_id');
    }
}
