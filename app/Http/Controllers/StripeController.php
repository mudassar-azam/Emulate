<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Illuminate\Support\Facades\Session;
use App\Models\Buyer\Invoice;
use App\Models\Buyer\OrdersInvoice;


class StripeController extends Controller
{

    public function handlePayment(Request $request)
    {
        $data = $request->all();
        \Log::info('Session data stored:', $data);
        session(['data' => $data]);
        $token = $data['token'];

        Stripe::setApiKey('sk_test_51Q64ki07Ru2Bf5p4T3Ey61acfLE8asNyX1jt3dczQM32M5fFR1i0qou6BMlN2ChDSAmW9WGmkEKpVZG05dnviiIu00XG7I8ujF');

        try {

            $totalPrice = session('total_price');
            $totalPriceInCents = intval($totalPrice * 100);

            $charge = Charge::create([
                'amount' => $totalPriceInCents, 
                'currency' => 'usd',
                'description' => 'Book Purchase',
                'source' => $token,
            ]);

            return redirect()->route('stripe.success');

        } catch (\Exception $e) {
            return redirect()->route('stripe.cancel')->with('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {

        $data = $request->all();
        session(['data' => $data]);
        $token = $data['token'];

        Stripe::setApiKey('sk_test_51Q64ki07Ru2Bf5p4T3Ey61acfLE8asNyX1jt3dczQM32M5fFR1i0qou6BMlN2ChDSAmW9WGmkEKpVZG05dnviiIu00XG7I8ujF');


        try {

            $totalPrice = session('total_price');
            $totalPriceInCents = intval($totalPrice * 100);

            $charge = Charge::create([
                'amount' => $totalPriceInCents, 
                'currency' => 'usd',
                'description' => 'Payment description',
                'source' => $token,
            ]);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            \Log::error('Stripe Error: ' . $e->getMessage());
            return response()->json(['status' => 'failure', 'message' => $e->getMessage()]);
        }
    }


    public function success()
    {
        $orders = session('orders');
        $pdetails = session('data');
        $pdetails['user_id'] = Auth::user()->id;
        $invoice = Invoice::create($pdetails);


        foreach($orders as $order){
            $order->payment_status = "paid";

            $product = $order->product;
            $product->stock = $product->stock - 1;
            $product->save(); 

            $order->save();

            OrdersInvoice::create([
                'invoice_id' => $invoice->id, 
                'order_id' => $order->id,
            ]);
        }

        session()->forget('total_price');
        session()->forget('orders');
        session()->forget('data');

        return view('buyer.payment.success');
    }

    public function cancel()
    {
        return view('buyer.payment.failed');
    }
}
