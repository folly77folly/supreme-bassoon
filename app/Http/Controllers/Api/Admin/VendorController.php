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
    public function store(VendorRequest $request){

       $formData = $request->validated();

       $vendor = new Vendor;

       $vendor->vendor_name = ($request->vendor_name);
       $vendor->contact_name = ($request->contact_name);
       $vendor->phone_no = $request->phone_no;
       $vendor->email = strtolower($request->email);
       $vendor->store_address = $request->store_address;
       $vendor->description = $request->description;
       $vendor->slug = Str::slug($request->vendor_name);
       $vendor->commission_fee = ($request->commission_fee);

       $vendor->save();

       return $this->apiResponse->created($vendor, 'Vendor created successfully');

    }

    //Get all vendors method
    public function index(){

       $vendors = Vendor::paginate(config('constants.PAGE_LIMIT.user'));
       return $this->apiResponse->successWithData($vendors, 'List of all vendors');

    }

    //Update vendor method defined here
    public function update(EditVendorRequest $request, $slug){

       $formData = $request->validated();

       $vendor = Vendor::where('slug', $slug)->first();

       if(!$vendor){
         return $this->apiResponse->failure('Vendor not found');
       }
       $vendor->fill($request->all())->save();

       return $this->apiResponse->successWithData($vendor, 'Vendor Updated successfully');

   }


    //Delete Vendors method here
    
    public function destroy($id)
    {
        $vendor = Vendor::destroy($id);
        return $this->apiResponse->success('Vendor  deleted successfully');
    }

    //Show a vendor
    public function show($slug){
      $vendor = Vendor::where('slug', $slug)->first();
      if(!$vendor){
        return $this->apiResponse->failure('Vendor not found');
      }
      return $this->apiResponse->successWithData($vendor, 'Vendor retrieved successfully',);
    }
}
