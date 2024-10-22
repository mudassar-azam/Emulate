<?php

namespace App\Models\Buyer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'order_id',
    ];
}
