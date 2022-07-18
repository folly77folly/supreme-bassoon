<?php
namespace App\Service;

use App\Models\Order;
use App\Models\OrderItems;
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
        $order->orderItem()->update($formData);
        return $order->load(
            'deliveryStatus:id,name',
            'orderStatus:id,name',
            'orderItem.product.vendor:id,vendor_name,phone_no,slug',
        );
    }

    public function updateOrderItemDeliveryStatus(int $id,  array $formData)
    {
        $orderItem = OrderItems::find($id);
        if(!$orderItem){
            throw new ApiResponseException('order item not found');
        }

        $orderItem->update($formData);
        return $orderItem->load(
            'deliveryStatus:id,name',
            'orderStatus:id,name',
            'product.vendor:id,vendor_name,phone_no,slug',
        );
    }

    public function viewOrder(int $id)
    {
        $order = Order::find($id);
        if(!$order){
            throw new ApiResponseException('order not found');
        }
        return $order->load(
        'deliveryStatus:id,name',
        'orderStatus:id,name',
        'orderItem.product.vendor:id,vendor_name,phone_no,slug',
        );
    }

    public function viewOrderItem(int $id)
    {
        $orderItem = OrderItems::find($id);
        if(!$orderItem){
            throw new ApiResponseException('order not found');
        }
        return $orderItem->load(
        'deliveryStatus:id,name',
        'orderStatus:id,name',
        'product.vendor:id,vendor_name,phone_no,slug',
        );
    }
}