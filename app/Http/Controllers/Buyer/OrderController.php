<?php

namespace App\Http\Controllers\Buyer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Buyer\Cart;
use App\Models\Buyer\Order;
use App\Models\Seller\Item;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        try {
            
            $validatedData = $request->validate([
                'lease_term' => 'required|string',
                'start_date' => 'required|string',
                'end_date' => 'required|string',
                'size' => 'required',
                'product_id' => 'required|exists:items,id',
            ]);


            $product = Item::find($validatedData['product_id']);

            if (preg_match('/\d+/', $validatedData['lease_term'], $matches)) {
                $lease_days = (int) $matches[0]; 
                $calculated_price = $lease_days * $product->rental_price; 
            }

            $cart = Cart::create([
                'user_id' => auth()->id(), 
                'product_id' => $validatedData['product_id'],
                'size_id' => $validatedData['size'],
                'product_owner_id' => $product->user_id,
                'lease_term' => $validatedData['lease_term'],
                'start_date' => $validatedData['start_date'], 
                'end_date' => $validatedData['end_date'],
                'type' => 'rent',
                'total_payment' => $calculated_price,
                'payment_status' => 'due',
            ]);

            return response()->json([
                'message' => 'Added to cart !',
                'order' => $cart
            ], 201);
            
        } catch (\Exception $e) {
            \Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }  

    public function buyNow(Request $request)
    {
        $product = Item::find($request->input('product_id'));
    
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['product_id'] = $request->input('product_id');
        $data['size_id'] = $request->input('selected_size');
        $data['product_owner_id'] = $product->user_id;
        $data['type'] = 'buy';
        $data['payment_status'] = 'due';
        $data['total_payment'] = $product->sale_price;
    
        $cart = Cart::create($data);
    
        return redirect()->back();
    }
    

    public function destroyOrder(Request $request , $id){

        $order = Order::find($id);
        $order->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }
}
