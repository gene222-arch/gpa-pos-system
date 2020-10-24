<?php

namespace App\Http\Controllers;

use PDF;
use Excel;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\CustomerOrderReportCSV;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\OrderStoreRequest;
use App\Exports\CustomerOrderReportExcel;
use Maatwebsite\Excel\Excel as FILE_EXTENSION;


class OrderController extends Controller
{

    public function index (Request $request)
    {   
        $orders = $this->setDateForPartialExport($request);

        return view('orders.index', [
            'orders' => $orders,
            'total' => Order::total($orders),
            'totalReceivedAmount' => Order::totalReceivedAmount($orders)
        ]);
    }

    public function store (OrderStoreRequest $request) 
    {   
        // fetch from request and insert customer id and user id
        $order = Order::create([
                'customer_id' => $request->customer_id,
                'user_id' => $request->user()->id
            ]);

        // Fetch all of products purchased by user
        $cart = $request->user()->cart()->get();

        foreach ($cart as $item) {
        // insert each item in order_items table
            $order->items()->create([
                'price' => $item->price,
                'quantity' => $item->pivot->quantity,
                'product_id' => $item->id
            ]);
            // diminish product quantity
            $item->quantity = $item->quantity - $item->pivot->quantity;
            $item->save();
            // insert amount passed from request into payments table with user id
            $order->payments()->create([
                'amount' => $request->amount,
                'user_id' => $request->user()->id
            ]);
        }

        // Remove current users Orders once submitted
        $request->user()->cart()->detach();
        return 'success';
        
    }

    public function exportToPDFWithDateSet(Request $request)
    {

        $orders = $this->setDateForPartialExport($request);
        
        $pdf = PDF::loadView('reports.customer-order-pdf', [
            'orders' => $orders,
            'total' => Order::total($orders),
            'totalReceivedAmount' => Order::totalReceivedAmount($orders) 
        ]);
        

        return $pdf->download('customer-order-data.pdf');

        // return view('reports.customer-order-pdf', [
        //     'orders' => $orders,
        //     'total' => Order::total($orders),
        //     'totalReceivedAmount' => Order::totalReceivedAmount($orders) 
        // ]);

    }

    public function exportToExcelWithDateSet(Request $request)
    {

        $orders = $this->setDateForPartialExport($request);
        $total = Order::total($orders);
        $totalReceivedAmount = Order::totalReceivedAmount($orders);

        $fileName = 'customer-order.xlsx';

        $this->excelStore(new CustomerOrderReportExcel($orders, $total, $totalReceivedAmount), $fileName);
        return Excel::download(
            new CustomerOrderReportExcel($orders, $total, $totalReceivedAmount), $fileName, 
            FILE_EXTENSION::XLSX,
            [
                'Content-Type' => 'text/xlsx'
            ]
        );
        
    }

    public function exportToCSVWithDateSet(Request $request)
    {

        $orders = $this->setDateForPartialExport($request);
        $total = Order::total($orders);
        $totalReceivedAmount = Order::totalReceivedAmount($orders);

        $fileName = 'customer-order.csv';
        $this->csvStore(new CustomerOrderReportCSV($orders, $total, $totalReceivedAmount), $fileName);

        return Excel::download(
            new CustomerOrderReportCSV($orders, $total, $totalReceivedAmount), $fileName, FILE_EXTENSION::CSV, 
        [
            'Contenty-Type' => 'text/csv'
        ]);
    }

    public function setDateForPartialExport(Request $request)
    {   

        $orders = new Order;

        $start_date = $request->start_date ?? $request->old('start_date');
        $end_date = $request->end_date ?? $request->old('end_date');

        if ($start_date) {

            $orders = $orders->where('created_at', '>=', $start_date);
        }

        if ($end_date) {

            $orders = $orders->where('created_at', '<=', $end_date);
        }

        $orders = $orders->with(['items', 'payments', 'customer'])
            ->latest()
            ->paginate(5)
            ->withPath('orders?name=GENE');

        return $orders;

    }

/**
 * Exporting all data
 */
    public function exportAllToPDF()
    {   
        $order = new Order;
        $all = $order->latest()->get();
        $pdf = PDF::loadView('reports.customer-order-pdf', [
        'orders' => $order->latest()->get(),
        'total' => Order::total($all),
        'totalReceivedAmount' => Order::totalReceivedAmount($all) ]);

        $this->pdfStore($pdf);

        return $pdf->download('customer-data.pdf');
    }

    public function exportAllToExcel()
    {
        $order = new Order;
        $all = $order->latest()->get();

        $total = Order::total($all);
        $totalReceivedAmount = Order::totalReceivedAmount($all);

        $fileName = 'customer-order.xlsx';
        $this->excelStore(
            new CustomerOrderReportExcel($all, $total, $totalReceivedAmount), $fileName
        );

        return Excel::download(
            new CustomerOrderReportExcel($all, $total, $totalReceivedAmount), $fileName
        );
         
    }

    public function exportAllToCSV()
    {
        $order = new Order;
        $all = $order->latest()->get();

        $total = Order::total($all);
        $totalReceivedAmount = Order::totalReceivedAmount($all);

        $fileName = 'customer-order.csv';
        $this->csvStore(new CustomerOrderReportCSV($all, $total, $totalReceivedAmount), $fileName);

        return Excel::download(
            new CustomerOrderReportCSV($all, $total, $totalReceivedAmount), 'customer-order.csv', FILE_EXTENSION::XLSX,
            [
                'Content-Type' => 'text/xlsx'
            ]
        );

          
    }

/**
 * EXCEL STORE
 */

    public function excelStore($data, $fileName)
    {
        Excel::store($data, $fileName);
    }

    public function csvStore($data, $fileName)
    {
        Excel::store($data, $fileName, null, FILE_EXTENSION::CSV);
    }

    public function pdfStore($pdf, $fileName)
    {
        $pdf->save(public_path('storage/files/PDF/customer-order-data.pdf'));
    }

}
/**
 * sum() is used for relationships
 */

 /**
  * Eager loading
  * passing the relationship/methods of Order to the "with(['']) parameter to make queries faster 
  * 
  * Since we used our relationship with other tables to calculate somethings we need to eager load
  */

