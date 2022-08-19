<?php

namespace App\Listeners;

use App\Event\DeliveryStatusEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendDeliveryStatusNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Event\DeliveryStatusEvent  $event
     * @return void
     */
    public function handle(DeliveryStatusEvent $event)
    {
        //
        $orderStatus = match($event->orderItem->delivery_status_id){
            config('constants.DELIVERY_STATUS.order_placed') => 'placed',
            config('constants.DELIVERY_STATUS.order_shipped') => 'shipped',
            config('constants.DELIVERY_STATUS.order_delivered') => 'delivered',
            config('constants.DELIVERY_STATUS.order_cancelled') => 'cancelled',
        };
        $event->orderItem->user->DeliveryStatusNotification($orderStatus);
    }
}
