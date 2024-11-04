<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Seller\Item;
use App\Models\Seller\Size;
use App\Models\Seller\ItemSize;
use App\Models\Category;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $result = Item::where('name', 'LIKE', "%{$query}%")->first();

        if (!$result) {
            return redirect()->back();
        }

        $id = $result->id;
        $item = Item::with('itemImages')->findOrFail($id);
        $products = Item::all();
        $categories = Category::all();
        $sizes = ItemSize::where('item_id', $id)->where('quantity', '>', 0)->get();
        $msizes = Size::all();
        return view('search',compact('products','sizes','msizes','categories','item'));
    }
}
