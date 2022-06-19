<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Service\OrderService;
use App\Service\ApiResponseService;
use App\Http\Controllers\Controller;
use App\Exceptions\ApiResponseException;
use App\Http\Requests\AdminUpdateDeliveryStatus;

class OrdersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrderService $orderService)
    {
        //
        // $orders = (new OrderService)->allOrders();
        $orders = $orderService->allOrders();
        return $this->apiResponse->successWithData($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUpdateDeliveryStatus $request, OrderService $orderService, $id)
    {
        //
        $validatedData = $request->validated();
        try {
            $order = $orderService->updateDeliveryStatus($id, $validatedData);
            return $this->apiResponse->successWithData($order);
        } catch (ApiResponseException $ape) {
            return $this->apiResponse->failure($ape->getMessage());
        } catch (\Throwable $th) {
            //throw $th;
            // $this->logError($th, __FUNCTION__);
            return $this->apiResponse->failure('something went wrong. try again later');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateOrderStatus(AdminUpdateDeliveryStatus $request, OrderService $orderService, $id){

    }
}
