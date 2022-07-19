<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Vendor;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Service\AuthService;
use Illuminate\Http\Request;
use App\Service\ApiResponseService;
use App\Http\Controllers\Controller;
use App\Http\Requests\VendorRequest;
use App\Http\Requests\EditVendorRequest;

class VendorController extends Controller
{
    //create vendor method here
    public function store(VendorRequest $request){

       $formData = $request->validated();

       $vendor = new Vendor;
      try {
        //code...
        $vendor->vendor_name = ($request->vendor_name);
        $vendor->contact_name = ($request->contact_name);
        $vendor->phone_no = $request->phone_no;
        $vendor->email = strtolower($request->email);
        $vendor->store_address = $request->store_address;
        $vendor->description = $request->description;
        $vendor->slug = Str::slug($request->vendor_name, '_');
        $vendor->commission_fee = ($request->commission_fee);

        $vendor->save();

        // Register Vendor Signup
        $signUpData['password'] = "password";
        $signUpData['email'] = $formData['email'];
        $signUpData['role_id'] = config('constants.ROLES.vendor');
        $adminUser = new AuthService($signUpData);
        $admin = $adminUser->registerAdminUser($signUpData);

        $updateVendor = Vendor::find($vendor->id);
        $updateVendor->admin_id = $admin->id;
        $updateVendor->save();

        return $this->apiResponse->created($vendor, 'Vendor created successfully');
      } catch (\Throwable $th) {
        //throw $th;
        $this->logError($th, __FUNCTION__);
        return $this->apiResponse->failure(parent::$uncaughtErrorMessage);
      }

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
      $vendor = Vendor::with(['product' => function($query){
        $query->latest()->get()->take(config('constants.RECORDS_TAKE.six'));
      }])
      ->where('slug', $slug)->first();
      if(!$vendor){
        return $this->apiResponse->failure('Vendor not found');
      }
      return $this->apiResponse->successWithData($vendor, 'Vendor retrieved successfully',);
    }

      //Show a vendor
      public function vendorAllProducts($slug){
        $vendor = Vendor::where('slug', $slug)->first();
        if(!$vendor){
          return $this->apiResponse->failure('Vendor not found');
        }
        $products = Product::where([
          'vendor_id' => $vendor->id,
        ])
        ->latest()
        ->paginate(config('constants.PAGE_LIMIT.admin'));
        return $this->apiResponse->successWithData($products);
      }
}
