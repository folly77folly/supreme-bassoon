<?php

namespace App\Listeners;

use App\Event\DeliveryStatusEvent;
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
        $orderItem = $event;
        $orderItem->user->DeliveryStatusNotification();
    }
}
