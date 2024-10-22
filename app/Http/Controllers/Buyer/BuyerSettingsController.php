<?php

namespace App\Http\Controllers\Buyer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Buyer\Order;
use App\Models\Seller\Item;
use App\Models\Buyer\BuyerSettings;


class BuyerSettingsController extends Controller
{
    public function settings()
    {
        $orders = Order::where('user_id' , Auth::user()->id)->get();
        $settings = BuyerSettings::where('user_id' , Auth::user()->id)->first();
        return view('buyer.settings', compact('orders','settings'));
    }

    public function update(Request $request)
    {
        $settings = BuyerSettings::where('user_id' , Auth::user()->id)->first();

        if ($request->has('email') && !empty($request->input('email'))) {
            $user = Auth::user();
            $user->email = $request->input('email');
            $user->save();
        }
        
        if ($settings) {
            $data = $request->all();
        
            $data['user_id'] = Auth::user()->id;
        
            $settings->update($data);
        
            return redirect()->back();
        }else{


            $data = $request->all();

            if ($request->hasFile('image')) {

                $image = $request->file('image');
                $destinationPath = public_path('buyers-profiles');
                $originalName = $image->getClientOriginalName();
                $uniqueName = time() . '_' . uniqid() . '_' . $originalName;
                $image->move($destinationPath, $uniqueName);
                $date['image'] = $uniqueName;
            }

            $data['user_id'] = Auth::user()->id;

            $setting = BuyerSettings::create($data);

            return redirect()->back();
        }
    }

    public function destroy($id){

        $order = Order::find($id);
        $product = Item::find($order->product_id);

        if($order->type == 'rent'){
            $product->available_to_rent = 1;
        }else{
            $product->available_to_buy = 1;
        }

        $product->save();
        $order->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }
}
