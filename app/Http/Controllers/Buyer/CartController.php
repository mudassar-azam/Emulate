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
        $user_id = Auth::user()->id;
    
        $cart = Cart::where('user_id', $user_id)->where('product_id', $product_id)->first();
    
        if ($cart) {
            return response()->json(['status' => 'exists', 'message' => 'Product is already in your cart!']);
        } else {
            $cart = Cart::create([
                'user_id' => $user_id,
                'product_id' => $product_id
            ]);
            
            $cartItems = Cart::with(['product.itemImages' => function($query) {
                $query->orderBy('id')->limit(1);
            }])->where('user_id', $user_id)->get();
            
    
            return response()->json(['status' => 'added', 'message' => 'Product added to cart successfully!', 'cart_items' => $cartItems]);
        }
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
    
        $outOfStockItems = [];
        $confirmedItems = [];
    
        foreach ($carts as $cart) {
            if ($cart->product->stock == 0) {
                $outOfStockItems[] = $cart->product->name;
                continue;
            }
    
            Order::create([
                'user_id' => Auth::user()->id,
                'product_id' => $cart->product->id,
                'product_owner_id' => $cart->product->user_id,
                'type' => 'cart',
                'payment_status' => 'due',
                'total_payment' => $cart->product->sale_price,
            ]);
    
            $confirmedItems[] = $cart->product->name;
        }
    
        foreach ($carts as $cart) {
            if (!in_array($cart->product->name, $outOfStockItems)) {
                $cart->delete();
            }
        }
    
        $responseMessage = '';
        if (!empty($confirmedItems)) {
            $responseMessage = 'Order Confirmed Successfully!';
        }
        if (!empty($outOfStockItems)) {
            if (!empty($confirmedItems)) {
                $responseMessage .= ' However, the following items are out of stock: ' . implode(', ', $outOfStockItems);
            } else {
                $responseMessage = 'All items are out of stock: ' . implode(', ', $outOfStockItems);
            }
        }
    
        return response()->json([
            'success' => !empty($confirmedItems),
            'message' => $responseMessage,
            'confirmed_items' => $confirmedItems,
            'out_of_stock_items' => $outOfStockItems,
        ]);
    }    
}
