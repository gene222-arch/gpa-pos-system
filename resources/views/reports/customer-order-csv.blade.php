<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Document</title>
</head>
<body>
    
    <h1 style="text-align: center">Customer Order List</h1>
    <table class="table table-striped">
        <thead class="table-header" style="background-color: #DDD;">
            <tr class="table-col-name">
                <th colspan="2" >#</th>
                <th colspan="2" >Customer Name</th>
                <th colspan="2" >Total</th>
                <th colspan="2" >Received Amount</th>
                <th colspan="2" >Status</th>
                <th colspan="2" >Balance</th>
                <th colspan="2" >Date Ordered</th>
                <th colspan="2" >Total</th>    
                <th></th>    
                <th colspan="2" >Product Cost</th> 
                <th colspan="2" >Accounts Receivable</th> 
            </tr>
        </thead>

        <tbody>
            @foreach ($orders as $order)

                <tr class="order__data__{{ $order->id }}" >
                    
                    <td  colspan="2"class="order-id" style="font-weight: 500; text-align:center;">{{ $order->id }}</td>
                    <td  colspan="2"class="order-customer-id-{{ $order->id }}" style="text-align: center;">{{ $order->getCustomerName() ?? '' }}</td>
                    <td  colspan="2"class="order-user-id-{{ $order->id }}" style="text-align: center;">
                        {{ config('settings.currency_symbol') . $order->getTotal() }}
                    </td>
                    <td colspan="2" style="text-align: center;">{{ config('settings.currency_symbol') . $order->receivedAmount() }}</td>
                    <td colspan="2" style="text-align: center;">
                        @if ($order->receivedAmount() == $order->getTotal())
                                Paid
                        @elseif ($order->receivedAmount() > $order->getTotal())
                                Change

                        @elseif ($order->receivedAmount() < $order->getTotal())
                                Partial
                            </span>    
                        @else
                                Not Paid
                        @endif
                    </td>
                    <td colspan="2" style="text-align: center;">
                        {{ config('settings.currency_symbol') . number_format($order->getTotal() - $order->receivedAmount(), 2) }}
                    </td>
                    <td colspan="2" style="text-align: center;">
                        {{ $order->created_at }}
                    </td>
                    <td colspan="3"></td>
                    <td colspan="2" style="text-align: center;">{{ config('settings.currency_symbol') . $total }}</td>
                    <td colspan="2" style="text-align: center;">{{ config('settings.currency_symbol') . $totalReceivedAmount }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


    @if (!count($orders))
        <img src="{{ asset('storage/table/empty_data.png') }}" alt="">
    @endif
</body>
</html>