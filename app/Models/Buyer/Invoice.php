<?php

namespace App\Models\Buyer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'fname',
        'lname',
        'address',
        'suite',
        'city',
        'state',
        'zip',
        'number',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }
}
