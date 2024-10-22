<?php

namespace App\Models\Buyer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Seller\Item;
use App\Models\Buyer\Cart;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cart_id',
        'product_id',
        'lease_term',
        'zip_code',
        'start_date',
        'end_date',
        'type',
        'product_owner_id',
        'payment_status',
        'total_payment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class , 'cart_id');
    }

    public function product()
    {
        return $this->belongsTo(Item::class , 'product_id');
    }
}
