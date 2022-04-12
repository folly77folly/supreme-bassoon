<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
   //Create Category 

    public function create(Request $request){

         $request->validate([
            'name'=>'required',
            'description'=>'required|max:400'
        ]);

        $data = ProductCategory::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json([
            $data,
            'status' => 'success',
        ]);
    }

    public function index(){

        $data = ProductCategory::all();
        return response()->json($data);
    }

    public function update(Request $request, $id){

        $request->validate([
            'name'=>'required',
            'description'=>'required|max:400'
        ]);

        $product = ProductCategory::find($id);
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

         return response()->json([
            $product,
            'status' => 'success',
        ]);
    }

    public function delete($id)
    {
        $product = ProductCategory::destroy($id);
        return response()->json([
            'msg' => 'Deleted Successfully',
            $product,
        ]);
    }

}
