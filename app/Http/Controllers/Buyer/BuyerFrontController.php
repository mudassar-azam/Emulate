<?php

namespace App\Http\Controllers\Buyer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Seller\Item;
use App\Models\Buyer\Order;
use App\Models\Information;

class BuyerFrontController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('role', 'seller')->take(4)->get();
        $sellers = User::where('role', 'seller')->get();
        $items = Item::all();

        // Get the email and modal parameters from the request
        $email = $request->query('email');
        $showModal = $request->query('modal') === 'true';

        return view('buyer.index', compact('users', 'sellers', 'items', 'email', 'showModal'));
    }
   

    public function fetchCeleb(Request $request)
    {
      $query = User::where('role', 'seller');

      if ($request->has('search')) {
          $search = $request->input('search');
          $query->where(function($q) use ($search) {
              $q->where('name', 'LIKE', "%$search%")
                ->orWhere('role', 'LIKE', "%$search%");
          });
      }
      $celebrities = $query->paginate(10);

      return view('buyer.celeb', compact('celebrities'));
    }

    public function addInformation(Request $request){
      $data = $request->all();
      $information = Information::create($data);
      return redirect()->back();
    }

}
