<?php

namespace App\Console\Commands;

use App\Models\OrderItems;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProductReviewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-product-review:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $twoDaysAgo = now()->subDays(config('constants.NUMBERS.two'));

        $orderItems = OrderItems::where('send_for_review', false)
        ->where('order_status_id', config('constants.ORDER_STATUS.completed'))
        ->where('updated_at', '<=', $twoDaysAgo)
        ->get();
        Log::info(json_encode($orderItems));
        //if the order items has been sent for review previously
        if($orderItems->count() > 0){
            $orderItems->each(function($orderItem){
                
                $orderItem->user->sendProductReviewReminderNotification($orderItem);

                OrderItems::find($orderItem->id)->update(['send_for_review' => true]);
            });
        }
    }
}
