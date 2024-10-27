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
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'images' => 'required',
            'images.*' => 'image',
            'category_id' => 'required',
            'item_type' => 'required',
            'rental_price' => 'required_if:item_type,for_rent',
            'sale_price' => 'required_if:item_type,for_sale',
            'stock' => 'required',
            'description' => 'required',
            'size' => 'required',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        $validator->sometimes('start_date', 'required|date|before:end_date', function ($input) {
            return $input->item_type === 'for_rent';
        });
    
        $validator->sometimes('end_date', 'required|date|after:start_date', function ($input) {
            return $input->item_type === 'for_rent';
        });
    
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

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'category_id' => 'required',
            'item_type' => 'required',
            'rental_price' => 'required_if:item_type,for_rent',
            'sale_price' => 'required_if:item_type,for_sale',
            'stock' => 'required',
            'description' => 'required',
            'size' => 'required',
            'images.*' => 'image',
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->sometimes('start_date', 'required|date|before:end_date', function ($input) {
            return $input->item_type === 'for_rent';
        });

        $validator->sometimes('end_date', 'required|date|after:start_date', function ($input) {
            return $input->item_type === 'for_rent';
        });

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

        $item = Item::findOrFail($id);
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $item->update($data);

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

        return response()->json(['success' => true, 'message' => 'Item updated successfully!']);
    }

    
}
