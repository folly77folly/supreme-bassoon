<?php

namespace App\Http\Controllers\Api\User;

use Throwable;
use Illuminate\Http\Request;
use App\Service\CouponService;
use App\Service\CheckoutService;
use App\Http\Controllers\Controller;
use App\Exceptions\ApiResponseException;
use App\Http\Requests\GetCouponValueRequest;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function couponValue(GetCouponValueRequest $request)
    {
        try {

            $amount_total = (new CheckoutService)->expectedPayment($request->all());
            $amountOff = (new CouponService($request->coupon_code))->getDiscountAmount(auth()->user(), $amount_total);
            return $this->apiResponse->successWithData($amountOff);
        } catch (ApiResponseException $ape) {
            //throw $th;
            return $this->apiResponse->failure($ape->getMessage());
        } catch (Throwable $th) {
            //throw $th;
            $this->logError($th, __FUNCTION__);
            return $this->apiResponse->failure(Parent::$uncaughtErrorMessage);
        }
       
    }
}
