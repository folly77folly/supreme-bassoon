<?php

namespace App\Console\Commands;

use App\Models\Cart;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AbandonedCartReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'abandonedCartReminder:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A User is reminded for left over cart after two days';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $startDate = now()->subDays(config('constants.NUMBERS.two'));
        $endDate = now();
        $carts = Cart::active()->distinct('user_id')->whereBetween('updated_at', [$startDate, $endDate])->get();
        // if the cart has records within the dates
        if($carts->count() > 0){
            $carts->each(function($cart){
                $cart->user->sendAbandonCartReminderNotification();
            });
        }
    }
}
