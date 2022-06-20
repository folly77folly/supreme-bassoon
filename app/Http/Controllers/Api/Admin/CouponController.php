<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Http\Requests\EditCouponRequest;
use App\Http\Requests\SaveCouponRequest;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $coupon = Coupon::paginate(config('constants.PAGE_LIMIT.user'));
       return $this->apiResponse->successWithData($coupon, 'List Of all Coupons');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveCouponRequest $request)
    {
       $formData = $request->validated();
       if (is_null($request->coupon_code)) {
            $randomString = Str::random(5);
            $formData['coupon_code'] = str('bubble_colony_')->append($randomString);
            $data = Coupon::create($formData);
            return $this->apiResponse->successWithData($data, 'Coupon created successfully');
        }

        $data = Coupon::create($formData);
        return $this->apiResponse->successWithData($data, 'Coupon created successfully');
      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $coupon = Coupon::findOrFail($id);
        return $this->apiResponse->successWithData($coupon, 'Get a coupon code successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditCouponRequest $request, $id)
    {
        $formData = $request->validated();
        $coupon = Coupon::findOrFail($id);
        $data = $coupon->update($formData);
        return $this->apiResponse->successWithData($coupon, 'Coupon Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon = Coupon::destroy($id);
        return $this->apiResponse->success('Coupon Deleted Successfully');
    }
}
