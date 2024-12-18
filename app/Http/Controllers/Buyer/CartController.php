<?php

namespace App\Http\Controllers\Buyer;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buyer\Cart;
use App\Models\Buyer\Order;
use App\Models\Seller\Item;


class CartController extends Controller
{

    public function getCartItems()
    {
        $user_id = Auth::user()->id;
        $cartItems = Cart::with('product.itemImages')->where('user_id', $user_id)->get();
        return response()->json($cartItems);
    }


    public function store(Request $request)
    {
        $product_id = $request->product_id;
        $product = Item::find($product_id);

        if($product->stock == 0){
            return response()->json(['status' => 'out_of_stock', 'message' => 'Product is out of stock!']);
        }
        $user_id = Auth::user()->id;
    
        $cart = Cart::where('user_id', $user_id)->where('product_id', $product_id)->first();
    
            $cart = Cart::create([
                'user_id' => $user_id,
                'product_id' => $product_id
            ]);
            
            $cartItems = Cart::with(['product.itemImages' => function($query) {
                $query->orderBy('id')->limit(1);
            }])->where('user_id', $user_id)->get();
            
    
            return response()->json(['status' => 'added', 'message' => 'Product added to cart successfully!', 'cart_items' => $cartItems]);
    }    

    public function remove($id)
    {
        $user_id = Auth::user()->id;
        $cartItem = Cart::where('id', $id)->where('user_id', $user_id)->first();

        if ($cartItem) {
            
            $cartItem->delete();

            return response()->json(['status' => 'removed', 'message' => 'Product removed from cart!']);
        }

        return response()->json(['status' => 'error', 'message' => 'Item not found in cart!']);
    }

    public function confirmOrder()
    {
        $carts = Cart::where('user_id', Auth::user()->id)->get();
    
        if ($carts->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No items present in the cart.']);
        }
    
        foreach ($carts as $cart) {
            $orderData = [
                'user_id' => Auth::user()->id,
                'product_id' => $cart->product->id,
                'size_id' => $cart->size_id,
                'product_owner_id' => $cart->product->user_id,
                'type' => $cart->type,
                'payment_status' => 'due',
            ];
        
            if ($cart->type == "rent") {
                $orderData['lease_term'] = $cart->lease_term;
                $orderData['start_date'] = $cart->start_date;
                $orderData['end_date'] = $cart->end_date;
                $orderData['total_payment'] = $cart->total_payment;
            }else{
                $orderData['total_payment'] = $cart->product->sale_price;
            }
        
            Order::create($orderData);
        }
    
        foreach($carts as $cart) {
            $cart->delete();
        }
    
        return response()->json(['success' => true, 'message' => 'Order created successfully!']);
    }    
}
