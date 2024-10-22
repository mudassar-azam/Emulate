<?php

namespace App\Models\Buyer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'dob',
        'number',
        'zipcode',
        'user_id'
    ];
}
