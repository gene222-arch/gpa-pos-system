<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{


    protected $orderItem;
    protected $payments;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->orderItem = new OrderItem;
        $this->payments = new Payment;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index ()
    {   

        return view('admin.dashboard', [
            'orderedItemsPerMonth_currentYear' => $this->setTotalOrderedItemsPerMonth(date('Y')),
            'orderedItemsPerMonth_previousYear' => $this->setTotalOrderedItemsPerMonth(date('Y') - 1),
            'totalItemsSold' => $this->totalItemsSold(),
            'paymentsPerMonth_currentYear' => $this->setTotalPaymentsPerMonth(date('Y')),
            'paymentsPerMonth_previousYear' => $this->setTotalPaymentsPerMonth(date('Y') - 1),
            'currentYearProfit' => $this->currentYearProfit(),
            'salesPerDay' => $this->setTotalSalesPerDay(date('Y'))
        ]);
    }

/**
 * Ordered ITEMS
 */
    protected function orderedItemsPerMonth ($year)
    {
        $orderPerMonth = $this->orderItem->select(DB::raw('SUM(quantity) as total_orders_per_month')) 
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total_orders_per_month');

        return $orderPerMonth;
    }
    
    protected function monthsInOrderItems ($year)
    {
        $months = $this->orderItem->select(DB::raw('MONTH(created_at) as months'))
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('months');

        return $months;
    }

    protected function setTotalOrderedItemsPerMonth ($year)
    {   
        $data = $this->dataStorageMonthly();
        $months = $this->monthsInOrderItems($year);
        $orderPerMonth = $this->orderedItemsPerMonth($year);

        foreach ($months as $key => $month) {
            
            $data[--$month] = $orderPerMonth[$key];
        }

        return $data;
    }

    protected function totalItemsSold ()
    {
        return $this->orderItem->sum('quantity');
    }

/**
 * TOTAL REVENUE PER MONTH
 */
    protected function totalPaymentsPerMonth ($year)
    {
        $totalRevenue = $this->payments->select(DB::raw('SUM(amount) as total_revenue_per_month'))
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total_revenue_per_month');

        return $totalRevenue;
    } 

    protected function monthsInPayments ($year)
    {
        $months = $this->payments->select(DB::raw('MONTH(created_at) as months'))
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('months');

        return $months;
    }

    protected function setTotalPaymentsPerMonth ($year)
    {
        $data = $this->dataStorageMonthly();
        $totalPayments = $this->totalPaymentsPerMonth($year);
        $months = $this->monthsInPayments($year);

        foreach ($months as $key => $month) {
            $data[--$month] = $totalPayments[$key];
        }
        return $data;
    }

    protected function currentYearProfit ()
    {
        return $this->payments->sum('amount');
    }

/**
 * DAILY SALES
 */

    protected function numberOfSalesPerDay ($year)
    {
        return $this->orderItem->select(DB::raw('SUM(quantity) as sales_per_day'))
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('DAYOFWEEK(created_At)'))
            ->pluck('sales_per_day');
    }

    protected function days ($year)
    {
        return $this->orderItem->select(DB::raw('DAYOFWEEK(created_at) as day'))
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('DAYOFWEEK(created_at)'))
            ->pluck('day');
    }

    protected function setTotalSalesPerDay($year)
    {
        $data = $this->dataStorageWeekly();
        $sales = $this->numberOfSalesPerDay($year);
        $days = $this->days($year);
        
        foreach ($days as $key => $day) {
            $data[--$day] = $sales[$key];
        }

        return $data;
    }

    protected function dataStorageMonthly ()
    {
        return [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    }

    protected function dataStorageWeekly ()
    {
        return [0, 0, 0, 0, 0, 0, 0];
    }

}


/**
 * Group by months will result in ascending order of months
 */
