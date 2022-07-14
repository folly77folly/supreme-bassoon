<?php

namespace App\Http\Controllers\Api\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\VendorDashboardService;

class VendorDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $en = CarbonImmutable::now()->locale('en_US');
        $start_date = $en->startOfWeek()->format('Y-m-d H:i'); 
        $end_date = $en->endOfWeek()->format('Y-m-d H:i'); 

       $orders = new  VendorDashboardService($start_date, $end_date, auth()->user()->vendor_id);
       $result = [
            'sales_value_by_date' => $orders->salesValueByDate(),
            'sales_volume_by_date' => $orders->salesVolumeByDate(),
            'total_sales_value' => $orders->TotalSalesValue(),
            'total_sales_volume' => $orders->TotalSalesVolume(),
            'total_vendors' => $orders->TotalVendors(),
            'chart' => $orders->ordersChart(),
            'recent_orders' => $orders->recentOrders(),
            'top_product' => $orders->popularProducts(),
            'top_vendors' => $orders->popularVendors(),
       ];
       return $this->apiResponse->successWithData($result);
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
    public function update(Request $request, $id)
    {
        //
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
