<?php

namespace App\Http\Controllers\Buyer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Buyer\Wishlist;
use App\Models\Seller\Item;
use App\Models\Seller\ItemImage;

class WishlistController extends Controller
{
    public function store(Request $request)
    {
        $productId = $request->input('product_id');
        $userId = Auth::user()->id;

        $product = Item::find($productId);
    
        $existingWishlistItem = Wishlist::where('user_id', $userId)
            ->where('name', $product->name)
            ->first();
    
        if ($existingWishlistItem) {
            return response()->json(['success' => false, 'message' => 'Item already in wishlist!'], 400);
        }
    
        $image = ItemImage::where('item_id', $product->id)->first();
    
        $wishlist = new Wishlist();
        $wishlist->name = $product->name;
        $wishlist->image = $image->image_name;
        $wishlist->user_id = $userId;
        $wishlist->save();
    
        return response()->json([
            'success' => true, 
            'message' => 'Item added to wishlist!',
            'item' => $wishlist
        ]);
    }

    public function getWishlistItems()
    {
        $wishlistItems = Wishlist::where('user_id', auth()->id())->get();
    
        return response()->json([
            'success' => true,
            'items' => $wishlistItems
        ]);
    }
    
    public function removeWishlistItem(Request $request)
    {
        $wishlistItem = Wishlist::find($request->id);
        if ($wishlistItem && $wishlistItem->user_id === auth()->id()) {
            $wishlistItem->delete();
            return response()->json(['success' => true, 'message' => 'Item removed from wishlist']);
        }

        return response()->json(['success' => false, 'message' => 'Item not found']);
    }
}
