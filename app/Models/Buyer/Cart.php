<?php

namespace App\Models\Buyer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Seller\Item;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id','product_owner_id','lease_term','start_date','end_date','type','total_payment','payment_status'];

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Item::class, 'product_id');
    }
}
