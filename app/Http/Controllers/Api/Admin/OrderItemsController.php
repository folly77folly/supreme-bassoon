<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Service\OrderService;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUpdateDeliveryStatus;

class OrderItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        try {

            $order = (new OrderService)->viewOrderItem($id);
            
            return $this->apiResponse->successWithData($order);

        } catch (ApiResponseException $ape) {

            return $this->apiResponse->failure($ape->getMessage());

        } catch (\Throwable $th) {
            //throw $th;
            $this->logError($th, __FUNCTION__);
            return $this->apiResponse->failure(parent::$uncaughtErrorMessage);
        }
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
            $orderItem = $orderService->updateOrderItemDeliveryStatus($id, $validatedData);

            return $this->apiResponse->successWithData($orderItem);

        } catch (ApiResponseException $ape) {

            return $this->apiResponse->failure($ape->getMessage());

        } catch (\Throwable $th) {
            //throw $th;
            $this->logError($th, __FUNCTION__);
            return $this->apiResponse->failure(parent::$uncaughtErrorMessage);
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
}
