<?php

namespace App\Http\Controllers\Api\User;

use App\Service\CartService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditCartRequest;
use App\Http\Requests\SaveCartRequest;
use App\Http\Requests\CartDecreaseRequest;
use App\Http\Requests\CartQuantityRequest;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $myCart =  (new CartService)->myCart(auth()->id());
        return $this->apiResponse->successWithData($myCart);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveCartRequest $request)
    {
        //
        $validatedData = $request->validated();
        try{
           $cart =  (new CartService)->saveCart($validatedData);
            return $this->apiResponse->created($cart, 'Product added to cart successfully');
        }catch(ApiResponseException $ape){
            $this->apiResponse->failure($ape->getMessage());
        }catch(Throwable $th){

            $this->apiResponse->failure('something went wrong, try again');
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
    public function update(EditCartRequest $request, $id)
    {
        //
        try {
            $cart =  (new CartService)->updateCart($id, $request->quantity);
            return $this->apiResponse->successWithData($cart, 'Product updated successfully');
        }catch(ApiResponseException $ape){
            $this->apiResponse->failure($ape->getMessage());
        }catch(Throwable $th){

            $this->apiResponse->failure('something went wrong, try again');
        }

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
        try {
            //code...
        $cart = (new CartService)->removeFromCart($id, auth()->id());
        return $this->apiResponse->successWithData($cart, 'Product removed successfully');
        }catch(ApiResponseException $ape){
            $this->apiResponse->failure($ape->getMessage());
        }catch(Throwable $th){

            $this->apiResponse->failure('something went wrong, try again');
        }

    }

    public function showCartSummary()
    {
        $cartSummary = (new CartService)->myCartSummary(auth()->id());
        return $this->apiResponse->successWithData($cartSummary, 'Cart order summary retrieved successfully');
    }

    public function quantityUpdate(CartQuantityRequest $request){
        $formData = $request->validated();
        try {
            //code...
        $cart = (new CartService)->cartQuantityUpdate($formData);
        return $this->apiResponse->successWithData($cart, 'Quantity Updated successfully');
        }catch(ApiResponseException $ape){
            $this->apiResponse->failure($ape->getMessage());
        }catch(Throwable $th){

            $this->apiResponse->failure('something went wrong, try again');
        }
    }

}
