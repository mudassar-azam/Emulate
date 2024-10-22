<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'post',
        'item_id',
        'user_id',
    ];

    public function postImages()
    {
        return $this->hasMany(PostImage::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id'); 
    }
}
