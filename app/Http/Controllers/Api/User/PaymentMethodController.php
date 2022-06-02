<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function paymentMethod(){
        $paymentMethod = PaymentMethod::all();
        return $this->apiResponse->successWithData($paymentMethod, 'List of all Payment Method');
    }
}
