<?php

namespace App\Http\Controllers\Api\User;

use Throwable;
use Illuminate\Http\Request;
use App\Service\CheckoutService;
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
        try{
            if($request->payment_method_id === 1){
                $paidOrder = $checkout->checkoutWithCard($validatedData);

            }elseif($request->payment_method_id === 2){
                $paidOrder = $checkout->checkoutWithCash($validatedData);
            }else{
                $paidOrder = $checkout->checkoutWithPoints($validatedData);
            }

            return $this->apiResponse->created($paidOrder, 'order placed successfully');
        }catch(ApiResponseException $ape){
            return $this->apiResponse->failure($ape->getMessage());
        }
        catch(Throwable $th){
            $this->logError($th, __FUNCTION__);
            return $this->apiResponse->failure('something went wrong. try again');
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
