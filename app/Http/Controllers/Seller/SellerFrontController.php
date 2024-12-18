<?php

namespace App\Http\Controllers\Seller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Seller\SellerSettings;
use Illuminate\Http\Request;
use App\Models\Seller\Item;
use App\Models\Seller\Post;
use App\Models\Seller\Size;
use App\Models\Seller\ItemSize;
use App\Models\Buyer\Order;
use App\Models\Information;
use App\Models\Subscriber;
use Illuminate\Support\Carbon;
use App\Models\Category;
use App\Mail\InvitEmail;
use App\Models\User;

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

        $orders = Order::where('payment_status','paid')->where('user_id',Auth::user()->id)->get();
        $salesData = [
            'Mon' => 0,
            'Tue' => 0,
            'Wed' => 0,
            'Thu' => 0,
            'Fri' => 0,
            'Sat' => 0,
            'Sun' => 0,
        ];
        foreach ($orders as $order) {
            $dayOfWeek = Carbon::parse($order->created_at)->format('D'); 
            $salesData[$dayOfWeek] += $order->total_payment;
        }

        $monthlyOrders = Order::where('payment_status', 'paid')
        ->where('user_id', Auth::user()->id)
        ->whereYear('created_at', date('Y'))
        ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total_orders'))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $data = [
            ['Month', 'Customers']
        ];
        
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    
        for ($i = 1; $i <= 12; $i++) {
            $monthlyTotal = $monthlyOrders->firstWhere('month', $i)->total_orders ?? 0;
            $data[] = [$monthNames[$i - 1], $monthlyTotal];
        }

        return view('seller.dashboard',compact('salesData','data'));
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
            $user->delete();
            $signUpLink = route('buyer.front', ['email' => $request->email, 'modal' => 'true']);
            Mail::to($request->email)->send(new InvitEmail($signUpLink));
    
            return redirect()->back();

        }else{

            session()->put('request_id', $request->id);
            $request->status = "approved";
            $request->save();

            $signUpLink = route('buyer.front', ['email' => $request->email, 'modal' => 'true']);
            Mail::to($request->email)->send(new InvitEmail($signUpLink));
            return redirect()->back();
        }
    }
}
