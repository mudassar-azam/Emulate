<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sale_price',
        'rental_price',
        'user_id',
        'category_id',
        'item_type',
        'description',
        'start_date',
        'end_date',
    ];

    public function itemImages()
    {
        return $this->hasMany(ItemImage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }

}
