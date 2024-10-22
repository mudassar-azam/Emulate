<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemImage extends Model
{
    protected $table = 'item_images';

    protected $fillable = ['item_id', 'image_name'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

}
