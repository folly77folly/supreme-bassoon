<?php

namespace App\Http\Controllers\Api\Admin;

use App\Service\ApiResponseService;
use App\Http\Requests\EditVendorRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Vendor;
use App\Http\Requests\VendorRequest;

class VendorController extends Controller
{
    //create vendor method here
    public function create(VendorRequest $request){

       $vendor = new Vendor;

       $vendor->vendor_name = strtolower($request->vendor_name);
       $vendor->contact_name = strtolower($request->contact_name);
       $vendor->phone_no = $request->phone_no;
       $vendor->email = strtolower($request->email);
       $vendor->store_address = $request->store_address;
       $vendor->description = $request->description;
       $vendor->slug = Str::slug($request->vendor_name);

       $vendor->save();

       return $this->apiResponse->successwithData($vendor, 'Vendor created successfully');

    }

    //Get all vendors method
    public function index(){

       $vendors = Vendor::paginate(4);
       return $this->apiResponse->successwithData($vendors, 'List of all vendors');

    }

    //Update vendore method defined here
    public function update(VendorRequest $request, $id){

      $vendors = Vendor::findOrFail($id);

       $vendors->vendor_name = strtolower($request->vendor_name);
       $vendors->contact_name = strtolower($request->contact_name);
       $vendors->phone_no = $request->phone_no;
       $vendors->email = strtolower($request->email);
       $vendors->store_address = $request->store_address;
       $vendors->description = $request->description;
       $vendors->slug = Str::slug($request->vendor_name);

       $vendors->save();

       return $this->apiResponse->successwithData($vendors, 'Vendor Updated successfully');

    }

    //Delete Vendors method here
    
    public function delete($id)
    {
        $vendor = Vendor::destroy($id);
        return $this->apiResponse->success('Product SubCategory Deleted Successfully');
    }

    //Show a vendor
    public function show(Request $request, Vendor $vendor){
     
      return $vendor;
    }
}
