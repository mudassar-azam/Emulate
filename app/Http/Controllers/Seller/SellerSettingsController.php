<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Seller\SellerSettings;

use Illuminate\Http\Request;

class SellerSettingsController extends Controller
{
    public function update(Request $request){

        $user_id = Auth::user()->id;

        $settings = SellerSettings::where('user_id',$user_id)->first();
        if($settings){

            $settings->introduction = $request->introduction ?? 'There is no introduction of this celebrity present yet.';
            $settings->facebook_link = (!empty($request->facebook_link) && $request->facebook_link !== 'N/A') ? $request->facebook_link : null;
            $settings->youtube_link = (!empty($request->youtube_link) && $request->youtube_link !== 'N/A') ? $request->youtube_link : null;
            $settings->instagram_link = (!empty($request->instagram_link) && $request->instagram_link !== 'N/A') ? $request->instagram_link : null;
            $settings->twitter_link = (!empty($request->twitter_link) && $request->twitter_link !== 'N/A') ? $request->twitter_link : null;


            if ($request->hasFile('profile_picture')) {

                $image = $request->file('profile_picture');
                $destinationPath = public_path('sellers-profiles');
                $originalName = $image->getClientOriginalName();
                $uniqueName = time() . '_' . uniqid() . '_' . $originalName;
                $image->move($destinationPath, $uniqueName);
                $settings->profile = $uniqueName;
            }


            $settings->user_id = $user_id;

            $settings->save();

            $user = User::find($user_id);
            $user->name = $request->name;
            $user->save();

            return response()->json(['success' => true, 'message' => 'Settings Updated successfully!']);

        }else{

            $settings = new SellerSettings();
            $settings->introduction = $request->introduction ?? 'There is no introduction of this celebrity present yet.';
            $settings->introduction = $request->introduction ?? 'There is no introduction of this celebrity present yet.';
            $settings->facebook_link = (!empty($request->facebook_link) && $request->facebook_link !== 'N/A') ? $request->facebook_link : null;
            $settings->youtube_link = (!empty($request->youtube_link) && $request->youtube_link !== 'N/A') ? $request->youtube_link : null;
            $settings->instagram_link = (!empty($request->instagram_link) && $request->instagram_link !== 'N/A') ? $request->instagram_link : null;
            $settings->twitter_link = (!empty($request->twitter_link) && $request->twitter_link !== 'N/A') ? $request->twitter_link : null;

            if ($request->hasFile('profile_picture')) {

                $image = $request->file('profile_picture');
                $destinationPath = public_path('sellers-profiles');
                $originalName = $image->getClientOriginalName();
                $uniqueName = time() . '_' . uniqid() . '_' . $originalName;
                $image->move($destinationPath, $uniqueName);
                $settings->profile = $uniqueName;
            }

            $settings->user_id = $user_id;

            $settings->save();

            $user = User::find($user_id);
            $user->name = $request->name;
            $user->save();

            return response()->json(['success' => true, 'message' => 'Settings Updated successfully!']);
        }
    }
}
