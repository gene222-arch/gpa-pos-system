<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use App\Exports\CustomerOrderReport;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Http\Request;

class CustomerOrderReportExcel implements FromView
{   

    private $orders;
    private $total;
    private $totalReceivedAmount;

    public function __construct($orders, $total, $totalReceivedAmount)
    {
        $this->orders = $orders;
        $this->total = $total;
        $this->totalReceivedAmount = $totalReceivedAmount;
    }

    public function view(): View 
    {
        return view('reports.customer-order-excel', [
            'orders' => $this->orders,
            'total' => $this->total,
            'totalReceivedAmount' => $this->totalReceivedAmount
        ]);
    }

}

  /**
   * EXCEL EXPORT
   * 
   * When exporting excel via laravel, and null driver bug occurs,
   * 1. php artisan config:clear
   * 
   * !!!IMPORTANT!!!
   * 2 tables are not allowed
   */