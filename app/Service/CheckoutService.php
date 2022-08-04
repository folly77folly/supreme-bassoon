<?php
namespace App\Service;

use Carbon\Carbon;
use App\Models\City;
use App\Models\Order;
use App\Models\Product;
use App\Service\CartService;
use App\Service\PayStackService;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ApiResponseException;

class CheckoutService{
     
    public function __construct(){

    }

    public function checkoutWithCard($formData)
    {

        if(! $this->isPaymentComplete($formData)){
            $expectedAmount = $this->expectedPayment($formData) - $formData['coupon_amount_off'];
            Throw new ApiResponseException("Invalid amount, Payment must be {$expectedAmount}");
        }
        
        $shippingRate = $this->shippingRate($formData['address_book_id']);
        $deliveryDate = ($this->shippingDays($formData['address_book_id']));
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
            'discount' => $formData['coupon_amount_off'],
            'delivery_days' => $deliveryDate,
            'paid' => true,
        ];

        //make call to pay-stack to verify the transaction was completed
   
        $verify = (config('app.env')) == 'testing' ? true : (new PayStackService)->verifyReference($formData['reference']);

        if($verify){
            $data['approved'] = true;
        }
        if (array_key_exists('product_id', $formData) && $formData['type'] === config('constants.CHECKOUT_TYPE.buy-now')){

            $orderItems = $this->getBuyNowOrderItems($formData['product_id'], $formData['quantity']);
            
        }else{
            $orderItems = $this->getUserOrderItems($formData['user_id']);
        }

        $order = DB::transaction(function () use($data, $orderItems, $formData){

            $order = Order::create($data);
            $order->orderItem()->createMany($orderItems);
            if($formData['type'] === config('constants.CHECKOUT_TYPE.checkout')){
                // update the cart to completed
                $buyers_cart = Cart::active()->where(['user_id' => $user_id])->update(['completed' => true]);
            }
            return $order->fresh()->load('user','orderStatus:id,name','deliveryStatus:id,name');
        });

        return $order;


    }

    //check if the amount to pay is equal to calculated amount
    public function isPaymentComplete($formData){
        
        return floatVal($formData['amount']) == (floatVal($this->expectedPayment($formData) - $formData['coupon_amount_off']));
    }

    public function expectedPayment($formData){
        if($formData['type'] == config('constants.CHECKOUT_TYPE.checkout')){
            $userCart = (new CartService)->myCartSummary($formData['user_id']);
            return ($userCart['estimated_total'] + $this->shippingRate($formData['address_book_id']));
        }
        $price = $this->productPrice($formData['product_id'], $formData['quantity']);
        $totalAmount = $price + $this->shippingRate($formData['address_book_id']);
        return round($totalAmount, 2);
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
                'user_id' => auth()->id(),
                'product_id' => $cart->product_id,
                'vendor_id' => $cart->vendor_id,
                'unit_price' => $cart->vendor_id,
                'quantity' => $cart->quantity,
                'total_amount' => $cart->total_amount,
                'total_discount' => $cart->total_discount,
                'total_price' => round(($cart->total_amount - $cart->total_discount),2),
            ];
            
        });
        return $orderItemsList[0]->toArray();
    }

    public function getBuyNowOrderItems($productId, $quantity){
        $product = Product::find($productId);
        $price = $product->is_discounted ? $product->discounted_price : $product->price;

        $orderItemsList[] = [
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'vendor_id' => $product->vendor_id,
                'unit_price' => $product->price,
                'quantity' => $quantity,
                'total_amount' => $product->price * $quantity,
                'total_discount' => $product->unit_discount * $quantity,
            ];
        
        return $orderItemsList;

    }

    public function productPrice($productId, $quantity){
        $product = Product::find($productId);
        if(!$product){
            return 0.00;
        }
        $price = $product->is_discounted == true ? $product->discounted_price : $product->price;
        return $price * $quantity;
    }

    // This will return the number of days for delivery
    public function shippingDays($addressId):string
    {
        if(!$addressId) return "1-3";
        $city = City::where('state_id', $addressId)->first();
        if(!$city) return "1-3";
        return $city->shipping_days;
    }

    public function getCouponValue(){

    }
}