<?php

namespace App\Http\Controllers\Buyer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buyer\Order;


class CheckoutController extends Controller
{
    public function checkout(){

        $orders = Order::where('payment_status' , 'due')->where('user_id' , Auth::user()->id)->get();
        return view('buyer.product.checkout',compact('orders'));

    }
}
