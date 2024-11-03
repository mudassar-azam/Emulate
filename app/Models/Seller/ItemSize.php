<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'size_id',
        'item_id',
        'quantity',
    ];

    public function size()
    {
        return $this->belongsTo(Size::class , 'size_id');
    }
}
