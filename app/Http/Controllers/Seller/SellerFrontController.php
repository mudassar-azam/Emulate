<?php

namespace App\Http\Controllers\Seller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvitEmail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Seller\Item;
use App\Models\Seller\Post;
use App\Models\Seller\Size;
use App\Models\Seller\ItemSize;
use App\Models\Buyer\Order;
use App\Models\User;
use App\Models\Information;
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
        $sizes = Size::all();
        return view('seller.index',compact('user','sizes','items','categories','posts'));

    }

    public function profile($id){

        $user = User::find($id);
        $items = Item::where('user_id' , $id)->get();
        $posts = Post::where('user_id' , $id)->get();
        if (Auth::check()) {
            $subscriber = Subscriber::where('subscriber_id', Auth::user()->id)
                ->where('seller_id', $user->id)
                ->first();
            
            return view('seller.seller-profile', compact('user', 'items', 'posts', 'subscriber'));
        } else {
            return view('seller.seller-profile', compact('user', 'items', 'posts'));
        }

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

    public function requests()
    {
        $requests = Information::where('status','pending')->get();
        return view('seller.request', compact('requests'));
    }

    public function approveRequest($id)
    {
        $request = Information::find($id);

        $user = User::where('email', $request->email)->first();

        if($user){

            $request->status = "approved";
            $request->save();
    
            $user->role = "seller";
            $user->password = Hash::make($request->password);
            $user->name = $request->name;
            $user->save();
    
            $signUpLink = route('buyer.front');
            Mail::to($request->email)->send(new InvitEmail($signUpLink));
    
            return redirect()->back();

        }else{

            $request->status = "approved";
            $request->save();
    
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => "seller",
            ]);
    
            $signUpLink = route('buyer.front');
            Mail::to($request->email)->send(new InvitEmail($signUpLink));
    
            return redirect()->back();
        }
    }
}
