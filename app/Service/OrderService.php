<?php
namespace App\Service;

use App\Models\Order;

class OrderService {
    public function approveReference($reference){
        $order = Order::where([
            'reference' => $reference,
            ])->first();

        if(!$order){
            return false;
        }
        $order = Order::where([
            'reference' => $reference,
            ])->update([
                'approved' => true,
            ]);
        return true;
    }
}