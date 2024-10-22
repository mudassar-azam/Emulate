<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'introduction',
        'facebook_link',
        'youtube_link',
        'instagram_link',
        'twitter_link',
        'user_id',
        'profile',
    ];

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }
}
