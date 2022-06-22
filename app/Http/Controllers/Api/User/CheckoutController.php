<?php

namespace App\Http\Controllers\Api\User;

use Throwable;
use Illuminate\Http\Request;
use App\Service\CouponService;
use App\Service\CheckoutService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Exceptions\ApiResponseException;
use App\Http\Requests\SaveCheckoutRequest;

class CheckoutController extends Controller
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
    public function store(SaveCheckoutRequest $request)
    {
        //
        $validatedData = $request->validated();
        $validatedData['user_id'] = auth()->id();
        $checkout = new CheckoutService ;
        $amountOff = 0;
        $validatedData['coupon_amount_off'] = $amountOff;
        try{
            if(!is_null($request->coupon_code)){
                $coupon = new CouponService($request->coupon_code) ;
                $amount_total = (new CheckoutService)->expectedPayment($request->all());
                $amountOff = $coupon->getDiscountAmount(auth()->user(), $amount_total);
                $validatedData['coupon_amount_off'] = $amountOff;

            }

            $paidOrder = DB::transaction(fn () => 
            match($request->payment_method_id){
                1 => $checkout->checkoutWithCard($validatedData),
                2 => $checkout->checkoutWithCash($validatedData),
                3 => $checkout->checkoutWithPoints($validatedData),
                 }
            );
                // Used Coupons
                if ($amountOff  > 0){
                    $coupon->recordUsedCoupon(auth()->user(), $amountOff);
                }

            return $this->apiResponse->created($paidOrder, 'order placed successfully');
        }catch(ApiResponseException $ape){
            return $this->apiResponse->failure($ape->getMessage());
        }
        catch(Throwable $th){
            $this->logError($th, __FUNCTION__);
            return $this->apiResponse->failure('something went wrongs. try again');
        }

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
}