<?php

namespace App\Http\Controllers\Buyer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Buyer\Order;
use App\Models\Seller\Item;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        try {
            
            $validatedData = $request->validate([
                'zip_code' => 'required|string|max:10',
                'lease_term' => 'required|string',
                'start_date' => 'required|string',
                'end_date' => 'required|string',
                'product_id' => 'required|exists:items,id',
            ]);

            $product = Item::find($validatedData['product_id']);

            if (preg_match('/\d+/', $validatedData['lease_term'], $matches)) {
                $lease_days = (int) $matches[0]; 
                $calculated_price = $lease_days * $product->rental_price; 
            }

            $order = Order::create([
                'user_id' => auth()->id(), 
                'product_id' => $validatedData['product_id'],
                'product_owner_id' => $product->user_id,
                'zip_code' => $validatedData['zip_code'],
                'lease_term' => $validatedData['lease_term'],
                'start_date' => $validatedData['start_date'], 
                'end_date' => $validatedData['end_date'],
                'type' => 'rent',
                'total_payment' => $calculated_price,
                'payment_status' => 'due',
            ]);

            return response()->json([
                'message' => 'Order created successfully!',
                'order' => $order
            ], 201);
            
        } catch (\Exception $e) {
            \Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }  

    public function buyNow(Request $request)
    {
        $rules = [
            'size' => 'required',
            'zip' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->getMessages() as $field => $messages) {
                $errors[] = [
                    'field' => $field,
                    'message' => $messages[0]
                ];
            }
            return response()->json(['success' => false, 'errors' => $errors], 422);
        }
    
        $product = Item::find($request->input('product_id'));
    
        $existingOrder = Order::where('product_id', $request->input('product_id'))->first();
    
        if ($existingOrder) {
            return response()->json(['success' => false], 400);
        }
    
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['product_id'] = $request->input('product_id');
        $data['product_owner_id'] = $product->user_id;
        $data['type'] = 'buy';
        $data['payment_status'] = 'due';
        $data['total_payment'] = $product->sale_price;
    
        $order = Order::create($data);
    
        return response()->json(['success' => true, 'message' => 'Order created successfully, Proceed to checkout!']);
    }
    

    public function destroyOrder(Request $request , $id){

        $order = Order::find($id);
        $order->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }
}
