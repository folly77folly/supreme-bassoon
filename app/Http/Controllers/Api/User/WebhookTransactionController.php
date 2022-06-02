<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Service\OrderService;
use App\Http\Controllers\Controller;

class WebhookTransactionController extends Controller
{
    //
    public function confirmTransfer()
    {
        
        if ((strtoupper($_SERVER['REQUEST_METHOD']) != 'POST' ) || !array_key_exists('x_paystack_signature', $_SERVER) ) 

                exit();

            // Retrieve the request's body
            $input = @file_get_contents("php://input");
            
            // dd(json_decode($input));

            // define('PAYSTACK_SECRET_KEY','SECRET_KEY');
            $pay_stack_secret_key = env("PAYSTACK_SECRET_KEY");
            // dd(hash_hmac('sha512', $input, $pay_stack_secret_key));
            // validate event do all at once to avoid timing attack

            if($_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] !== hash_hmac('sha512', $input, $pay_stack_secret_key))

                exit();

            // http_response_code(200);

            // parse event (which is json string) as object
            $response = json_decode($input);
            // dd($response);
            // Do something - that will not take long - with $event
            $result = $this->handleEvent($response);
            // dd($result);
            http_response_code($result);

            // $event = json_decode($input);

            exit();
    }

    public function handleEvent ($event){
        switch ($event->event) {
            case 'charge.success':
               return $this->approveTransaction($event->data->reference);
            default:
                # code...
                break;
        }
    }

    public function approveTransaction($reference)
    {
        // dd($reference);
        $order =  (new OrderService)->approveReference($reference);
        // dd($order);
        $value = $order == true ?  200: 500;
        return $value;
    }
}
