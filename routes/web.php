<?php

use App\Models\Order;
use App\Models\OrderItems;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/{id}', function ($id) {
    $order =  Order::find($id);
    // dd($order);
    return view('emails.orderCompleted', ['order' => $order]);
});
Route::get('product-review/{id}', function ( int $id) {
    $orderItem =  OrderItems::find($id);
    $fullName = "Akeem Eniodunmo";
    // dd($id);
    return view('emails.product_review', [
        'orderItem' => $orderItem, 
        'fullName'  => $fullName
    ]);
});


