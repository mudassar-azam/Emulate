<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Seller\Item;
use App\Models\Seller\ItemImage;

class ItemController extends Controller
{
    public function store(Request $request){

        $rules = [
            'name' => 'required',
            'category_id' => 'required',
            'item_type' => 'required',
            'rental_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required',
            'description' => 'required',
            'size' => 'required',
            'images' => 'required',
            'images.*' => 'image',
        ];
        
        
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->getMessages() as $field => $messages) {
                $errors[] = [
                    'field' => $field,
                    'message' => $messages[0]
                ];
            }
        
            return response()->json(['success' => false, 'errors' => $errors], 422);
        }

        $data = $request->all();

        $data['user_id'] = Auth::user()->id;

        $item = Item::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $destinationPath = public_path('item-images');
                $originalName = $image->getClientOriginalName();
                $uniqueName = time() . '_' . uniqid() . '_' . $originalName;
                $image->move($destinationPath, $uniqueName);
                ItemImage::create([
                    'item_id' => $item->id,
                    'image_name' => $uniqueName,
                ]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Item created successfully!']);
    }
}
