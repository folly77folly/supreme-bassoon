<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Service\ApiResponseService;
use App\Http\Requests\VendorRequest;

class VendorController extends Controller
{
    //create vendor method here
    public function create(VendorRequest $request){

       $vendor = new Vendor;

       $vendor->vendor_name = $request->vendor_name;
       $vendor->contact_name = $request->contact_name;
       $vendor->phone_no = $request->phone_no;
       $vendor->email = $request->email;
       $vendor->store_address = $request->store_address;
       $vendor->description = $request->description;

       $vendor->save();

       return $this->apiResponse->successwithData($vendor, 'Vendor created successfully');

    }
}
