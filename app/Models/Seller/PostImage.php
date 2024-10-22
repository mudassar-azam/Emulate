<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    protected $table = 'post_images';

    protected $fillable = ['post_id', 'image_name'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
