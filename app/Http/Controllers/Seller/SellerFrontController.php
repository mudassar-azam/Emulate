<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Seller\Item;
use App\Models\Seller\Post;
use App\Models\Buyer\Order;
use App\Models\User;
use App\Models\Subscriber;
use App\Models\Category;

class SellerFrontController extends Controller
{
    public function index(){

        $user = Auth::user();

        if($user->role == 'admin'){
            $items = Item::all();
            $posts = Post::all();

        }else{
            $items = Item::where('user_id' , Auth::user()->id)->get();
            $posts = Post::where('user_id' , Auth::user()->id)->get();
        }
        
        $categories = Category::all();
        return view('seller.index',compact('user','items','categories','posts'));

    }

    public function profile($id){

        $user = User::find($id);
        $items = Item::where('user_id' , $id)->get();
        $posts = Post::where('user_id' , $id)->get();
        $subscriber = Subscriber::where('subscriber_id' , Auth::user()->id)->where('seller_id' , $user->id)->first();
        return view('seller.seller-profile',compact('user','items','posts','subscriber'));

    }

    public function subscribe(Request $request){

        $data = $request->all();
        $data['subscriber_id'] = Auth::user()->id;
        $subscriber = Subscriber::create($data);

        $user = User::find($request->seller_id);
        $user->subscribers = $user->subscribers + 1;
        $user->save();

        return redirect()->back();
    }


    public function dashboard(){
        return view('seller.dashboard');
    }

    public function order()
    {
        $orders = Order::where('product_owner_id' , Auth::user()->id)->get();
        return view('seller.orders',compact('orders'));
    }

    public function showSignupForm(Request $request)
    {
        $email = $request->query('email');
        $showModal = $request->query('modal') === 'true'; 
        return view('seller.signup', compact('email', 'showModal'));
    }
}
