<?php
namespace App\Service;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Exceptions\ApiResponseException;
use App\Http\Requests\AdminUpdateDeliveryStatus;

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

    public function allOrders(){
        return Order::with('user',
        'deliveryStatus:id,name',)
        ->latest()
        ->paginate(config('constants.PAGE_LIMIT.admin'));
    }

    public function updateDeliveryStatus(int $id,  array $formData)
    {
        $order = Order::find($id);
        if(!$order){
            throw new ApiResponseException('order not found');
        }
        $order->fill($formData)->save();
        return $order->load('deliveryStatus:id,name');
    }
}