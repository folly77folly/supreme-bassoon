<?php
namespace App\Service;

use App\Service\CartService;
use App\Exceptions\ApiResponseException;

class CheckoutService{
     
    public function __construct(){

    }

    public function checkoutWithCard($formData)
    {
        // return $formData;
        // check the amount paid 
        $userCart = (new CartService)->myCartSummary($formData['user_id']);
        if($formData['amount'] !== $userCart['estimated_total']){
            Throw new ApiResponseException("Invalid amount, Payment must be {$userCart['estimated_total']}");
        };

        //save data to order table
        $Order::create($formData);


        //save data to order details
        $OrderDetails::create($data);
    }


    public function checkPayment($amount, $userId){
        $userCart = (new CartService)->myCartSummary($formData['user_id']);
        if($formData['amount'] !== $userCart['estimated_total']){
            return "Invalid amount, Payment must be {$userCart['estimated_total']}";
        };
    }
}