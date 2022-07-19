<?php
namespace App\Service;

use App\Models\Order;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\OrderItems;

class VendorDashboardService{

    public function __construct(
        protected  $start_date, 
        protected  $end_date,
        protected  $vendor_id,)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->vendor_id = $vendor_id;
    }

    public function salesValueByDate()
    {
        return OrderItems::vendorOwner()->whereBetween('created_at', [$this->start_date, $this->end_date])
        ->where([
            'order_status_id' => config('constants.ORDER_STATUS.completed')
            ])
        ->get()->sum('total_price');
    }

    public function salesVolumeByDate()
    {
        return OrderItems::vendorOwner()->whereBetween('created_at', [$this->start_date, $this->end_date])
        ->where([
            'order_status_id' => config('constants.ORDER_STATUS.completed')
            ])
        ->get()->count();
    }

    public function TotalSalesValue()
    {
        return OrderItems::vendorOwner()
        ->where([
            'order_status_id' => config('constants.ORDER_STATUS.completed')
            ])
        ->get()->sum('total_price');
    }

    public function TotalSalesVolume()
    {
        return OrderItems::vendorOwner()->where([
            'order_status_id' => config('constants.ORDER_STATUS.completed')
            ])
        ->get()->count();
    }

    public function TotalOrders()
    {
        // dd(OrderItems::VendorOwner()->get());
        return OrderItems::VendorOwner()->get()->count();
    }

    public function TotalCancelledOrders()
    {
        return OrderItems::VendorOwner()->where([
            'order_status_id' => config('constants.ORDER_STATUS.cancelled')
        ])->get()->count();
    }

    public function totalProducts()
    {
        return Product::productOwner()->get()->count();
    }

    public function OrdersCancelledByDate()
    {
        return OrderItems::vendorOwner()->whereBetween('created_at', [$this->start_date, $this->end_date])
        ->where([
            'order_status_id' => config('constants.ORDER_STATUS.cancelled')
            ])
        ->get()->count();
    }

    public function ordersChart()
    {
        $currentYear =  date('Y');
        $label = array();
        $data = array();
        $user_id =  Auth()->id();
        $totalEarnings = 0;

        for ($i = 1; $i < 13; $i++) {
            $query_date =  $currentYear . "-" . $i . "-01";
            $endDate =  date('Y-m-t', strtotime($query_date));
            $startDate =  date('Y-m-01', strtotime($query_date));
            $month =  date('M', strtotime($query_date));
            $earnings = $this->earningsByDate($startDate, $endDate);
            array_push($label, $month);
            array_push($data, $earnings);
            $totalEarnings = $totalEarnings + $earnings;
        }
        return [
            'data' => $data,
            'label' => $label,
            'totalEarnings' => strVal($totalEarnings),
        ];
    }

    private function earningsByDate($startDate, $endDate)
    {
        $earings = OrderItems::vendorOwner()->where([
            'order_status_id' => config('constants.ORDER_STATUS.completed')
        ])
            ->whereBetween('created_at', [$startDate, $endDate])->sum('total_price');
        return  strVal($earings);
    }

    public function recentOrders()
    {
        return OrderItems::vendorOwner()->with('user')
        ->where([
            'order_status_id' => config('constants.ORDER_STATUS.pending')
            ])
        ->latest()
        ->take(config('constants.PAGE_LIMIT.admin'))
        ->get();
    }

    public function cancelledOrders()
    {
        return OrderItems::vendorOwner()->with('user')
        ->where([
            'order_status_id' => config('constants.ORDER_STATUS.cancelled')
            ])
        ->latest()
        ->take(config('constants.PAGE_LIMIT.admin'))
        ->get();
    }

    //off
    public function popularProducts()
    {
        $products = Product::take(config('constants.RECORDS_TAKE.five'))->get();
        $sortedProducts = $products->sortByDesc('sales_count');
        $result = $sortedProducts->values();
        return $result;
    }
    //off
    public function popularVendors()
    {
        $vendors = Vendor::take(config('constants.RECORDS_TAKE.five'))->get();
        $sortedVendors = $vendors->sortByDesc('sales_count');
        $result = $sortedVendors->values();
        return $result;
    }
}