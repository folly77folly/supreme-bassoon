<?php
namespace App\Service;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ApiResponseException;

class CartService{
    public function saveCart($validatedData){
        $product = Product::find($validatedData['product_id']);
        // dd($product);
        //check if product is in stock
        if (!$product->inventory_status === 'Out of stock' ) {
            throw new ApiResponseException('product out of stock');
        };
        

        $buyers_cart = Cart::where([['user_id', Auth()->id()], ['status', true, ['quantity', '!=', 0]]])->with('product')->first();

        $buyerCart  = DB::transaction(function() use($validatedData, $product){

            $cart = Cart::updateOrCreate(
                ['user_id' => Auth()->id(), 'product_id' => $validatedData['product_id'], 'status' => true],
                [
                    'user_id' => Auth()->id(),
                    'product_id' => $validatedData['product_id'],
                    'quantity' => $validatedData['quantity'],
                    'vendor_id' => $product->vendor_id,
                    'status' => true
                ]
            );
            return $cart;
        });

        return $buyerCart;
    }

    public function updateCart($id, $quantity){
        $cart = Cart::where('product_id', $id)->first();
        if(! $cart){
            throw new ApiResponseException('Product not found');
        }
        $cart->update([
            'quantity' => $quantity,
        ]);

    }

    public function cartQuantityUpdate($validatedData)
    {

        $buyers_cart = Cart::where([
            ['user_id', auth()->id()],
            ['status', true],
            ['product_id', $validatedData['product_id']]
        ])->with('product')->first();

        

        if (!$buyers_cart) {
            throw new ApiResponseException ('No Product found');
        }
        if($validatedData['type'] === 1){
            $quantity = $buyers_cart->quantity + $validatedData['quantity'];
        }else{

            $quantity = $buyers_cart->quantity - $validatedData['quantity'];
        }

        $buyers_cart->update([
            'quantity' => $quantity,
            'status' => true,

        ]);
        
        if ($quantity < 1) {
            $buyers_cart->update([
            'quantity' => 0,
            'status' => false,

            ]);
        }
        $cart = $this->myCart(auth()->id());
        return $cart;


    }

    public function myCart($user_id){
        $buyers_cart = Cart::active()->where(['user_id' => $user_id])->get();
        return $buyers_cart;
    }

    public function myCartSummary($user_id){

        $buyers_cart = Cart::active()->where(['user_id' => $user_id])->get()->toArray();
        $total_amount = array_sum(array_column($buyers_cart, 'total_amount'));
        $total_discount = array_sum(array_column($buyers_cart, 'total_discount'));
        $cart_summary = [
            'total_items' => count($buyers_cart),
            'total_amount' => $total_amount,
            'discount' => $total_discount,
            'estimated_total' => round(($total_amount - $total_discount), 2),
        ];

        return collect($cart_summary);
    }

    public function removeFromCart($id, $user_id)
    {
        $product = Product::find($id);
        if(!$product){
            throw new ApiResponseException('Product not found');
        }

        Cart::where([
            ['user_id', $user_id],
            ['status', true],
            ['product_id', $id]
        ])->delete();

        $cart = $this->myCart($user_id);
        return $cart;
    }


}