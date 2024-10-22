<?php

namespace App\Http\Controllers\Buyer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seller\Item;
use App\Models\User;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(){
        $products = Item::all();
        $sellers = User::where('role', 'seller')->get();
        $categories = Category::all();
        return view('buyer.product.index',compact('products','sellers','categories'));
    }

    public function details($id){
        $item = Item::with('itemImages')->findOrFail($id);
        $products = Item::all();
        return view('buyer.product.product-details',compact('products','item'));
    }

    public function rent(){
        $products = Item::where('item_type' , 'for_rent')->get();
        $sellers = User::where('role', 'seller')->get();
        $categories = Category::all();
        return view('buyer.product.rent',compact('sellers','categories','products'));
    }

    public function buy(){
        $products = Item::where('item_type' , 'for_sale')->get();
        $sellers = User::where('role', 'seller')->get();
        $categories = Category::all();
        return view('buyer.product.buy',compact('categories','sellers','products'));
    }

    public function rentDetails($id){
        $item = Item::with('itemImages')->findOrFail($id);
        $products = Item::where('item_type' , 'for_rent')->get();
        return view('buyer.product.rent-details',compact('products','item'));
    }

    public function buyDetails($id){
        $item = Item::with('itemImages')->findOrFail($id);
        $products = Item::where('item_type' , 'for_sale')->get();
        return view('buyer.product.buy-details',compact('products','item'));
    }

    public function wishlistProductDetails($name) {
        $item = Item::with('itemImages')->where('name', $name)->firstOrFail();
        $products = Item::all();
        return view('buyer.product.product-details', compact('products', 'item'));
    }    
}
