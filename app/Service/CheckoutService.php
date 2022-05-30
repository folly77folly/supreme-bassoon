<?php
namespace App\Service;

use App\Models\City;
use App\Models\Order;
use App\Service\CartService;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ApiResponseException;

class CheckoutService{
     
    public function __construct(){

    }

    public function checkoutWithCard($formData)
    {
        // dd($formData);
        // check the amount paid 
        // $userCart = (new CartService)->myCartSummary($formData['user_id']);
        // if($formData['amount'] !== $userCart['estimated_total']){
        //     Throw new ApiResponseException("Invalid amount, Payment must be {$userCart['estimated_total']}");
        // };

        if(! $this->isPaymentComplete($formData['amount'], $formData['user_id'], $formData['address_book_id'])){
            $expectedAmount = $this->expectedPayment($formData['amount'], $formData['user_id'], $formData['address_book_id']);
            Throw new ApiResponseException("Invalid amount, Payment must be {$expectedAmount}");
        }
        
        $shippingRate = $this->shippingRate($formData['address_book_id']);
        $deliveryDate = now();
        //save data to order table
        $data = [
            'user_id' => $formData['user_id'],
            'children_profile_id' => $formData['children_profile_id'],
            'address_book_id' => $formData['address_book_id'],
            'payment_method_id' => $formData['payment_method_id'],
            'total_price' => $formData['amount'],
            'shipping_price' => $shippingRate,
            'trans_id' => $formData['trans_id'],
            'reference' => $formData['reference'],
            'delivery_date' => $deliveryDate,
            'paid' => true,
        ];

        $orderItems = $this->getUserOrderItems($formData['user_id']);

        $order = DB::transaction(function () use($data, $orderItems){

            $order = Order::create($data);
            $order->orderItem()->createMany($orderItems);

            return $order;
        });

        return $order;


    }


    public function isPaymentComplete($amount, $userId, $addressId = null, $type = null){
        return $amount === $this->expectedPayment($amount, $userId, $addressId = null, $type = null);
    }

    public function expectedPayment($amount, $userId, $addressId = null, $type = null){
        $userCart = (new CartService)->myCartSummary($userId);
        return ($userCart['estimated_total'] + $this->shippingRate($addressId));
    }

    public function shippingRate($addressId)
    {
        if(!$addressId) return 0;
        $city = City::where('state_id', $addressId)->first();
        if(!$city) return 0;
        return round($city->shipping_rate, 2);
    }

    public function getUserOrderItems($userId){
        $carts = (new CartService)->myCart($userId);

        $orderItemsList[] = $carts->map(function($cart, $key){
        
            return [
                'product_id' => $cart->product_id,
                'vendor_id' => $cart->vendor_id,
                'unit_price' => $cart->vendor_id,
                'quantity' => $cart->quantity,
                'total_amount' => $cart->total_amount,
                'total_discount' => $cart->total_discount,
                'paid' => true,
            ];
            
        });
        return $orderItemsList[0]->toArray();
    }
}