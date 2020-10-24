<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!-- Fonts -->
    <title>Document</title>
{{-- Custom Styling --}}
    <style>
        /* Global */
        body,
        ::before,
        ::after {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica';
            box-sizing: border-box;
        }

        body {
            width: 100%;
            height: auto;
        }

        .row {
            display: flex;
            flex-flow: row wrap;
        }

        /* Typography */

        h1,
        h2,
        h3,
        h4,
        p,
        a,
        td,
        th{
            line-height: 1.6;
            font-family: 'Nunito Sans', sans-serif;
            margin: 0;
            padding: 0;
        }

        td {
            font-size: .75rem;
        }

        thead th {
            font-weight: 700;
            border-top: .025px solid rgb(66, 66, 66);
            border-bottom: .025px solid rgb(66, 66, 66);
            font-size: .75rem;
            

        }

        @page { 
            size: 600pt 800pt; 
        }


        /* Components */
        table {
            margin-top: 2.5rem;
            width: 100%;
            border-collapse: collapse;
        }
        table tr:nth-child(even) {
            background-color: rgb(243, 243, 243);
            border-top: .025px solid rgb(187, 187, 187);
            border-bottom: .005px solid rgb(182, 182, 182);
        }
        tr, td, th {
            padding: 1rem;
            text-align: center;
        }

        .customer__data__header > * {
            margin: .25rem;
            padding: .25rem;
        }
        .customer__data__header .pdf .title{
            font-size: 3rem;
        }

        .company-info {
            font-size: .75rem;
        }
        .pdf {
            display: block;
            text-align: right;
        }

        .pdf .date {
            font-size: .75rem;
        }

        .badge {
            padding: .25rem .25rem;
            border-radius: .25rem;
            font-weight: 600;
        
        }
        .badge-success {
            color: white;
            background-color: rgb(0, 199, 0);
        }

        .badge-light {
            color: black;
            background-color: rgb(240, 239, 239);
        }

        .badge-danger {
            color: white;
            background-color: tomato;
        }
        .badge-warning {
            color: white;
            background-color: rgb(221, 221, 28);
        }

        .total {
            color: #FFF;
            background: rgb(124, 124, 124);
            
        }

        #container {
            display: block;
            
        }
    </style>
</head>
<body>
    <div class="container">
        
        <div 
        class="customer__data__header" style="">
            <div class="company-info" style="display:inline-block;">
               <h4>Artista's Online Shop International, Inc </h4>
               <address>134 Daisy St<p>Brgy. Lingga Calamba City, Laguna 4027</p></address>
            </div>

            <div class="pdf">
                <h1 class="title">Order Lists</h1>
                <div class="date">
                    <p>From: {{ request('start_date') ?? date('Y-m-d') }} to {{ request('end_date') ?? date('Y-m-d') }}</p>
                </div>
            </div>
        </div>
        
        <table class="table table-striped">
            <thead class="table-header">
                <tr class="table-col-name">
                    <th>#</th>
                    <th>Customer Name</th>
                    <th>Total</th>
                    <th>Received Amount</th>
                    <th>Status</th>
                    <th>Balance</th>
                    <th>Date Ordered</th>
                </tr>
            </thead>
    
            <tbody>
                @foreach ($orders as $order)
    
                    <tr class="order__data__{{ $order->id }}">
                        
                        <td class="order-id">{{ $order->id }}</td>
                        <td class="order-customer-id-{{ $order->id }}">{{ $order->getCustomerName() ?? '' }}</td>
                        <td class="order-user-id-{{ $order->id }}">
                            {{ config('settings.currency_symbol') . $order->getTotal() }}
                        </td>
                        <td>{{ config('settings.currency_symbol') . $order->receivedAmount() }}</td>

                        @if ($order->receivedAmount() == $order->getTotal())
                            <td class="badge badge-success">
                                Paid
                            </td>
                        @elseif ($order->receivedAmount() > $order->getTotal())
                            <td class="badge badge-light">
                                Change
                            </td>
                        @elseif (empty($order->receivedAmount()))
                            <td class="badge badge-warning">
                                Partial
                            </td>    
                        @else
                            <td class="badge badge-danger">
                                Not Paid
                            </td>
                        @endif
                   
                        <td>
                            {{ config('settings.currency_symbol') . number_format($order->getTotal() - $order->receivedAmount(), 2) }}
                        </td>
                        <td>
                            {{ $order->created_at }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="total">
                <th><h4>Total</h4></th>
                <th></th>
                <th>{{ config('settings.currency_symbol') . $total }}</th>
                <th>{{ config('settings.currency_symbol') . $totalReceivedAmount }}</th>
                <th></th>
                <th></th>
                <th></th>
            </tfoot>
        </table>
     
    
        @if (!count($orders))
            <img src="{{ asset('storage/table/empty_data.png') }}" alt="">
        @endif
    </div>
    {{-- <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
 --}}

<script>
//     Highcharts.chart('container', {
//     chart: {
//         plotBackgroundColor: null,
//         plotBorderWidth: null,
//         plotShadow: false,
//         type: 'pie'
//     },
//     title: {
//         text: 'Browser market shares in January, 2018'
//     },
//     tooltip: {
//         pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
//     },
//     accessibility: {
//         point: {
//             valueSuffix: '%'
//         }
//     },
//     plotOptions: {
//         pie: {
//             allowPointSelect: true,
//             cursor: 'pointer',
//             dataLabels: {
//                 enabled: true,
//                 format: '<b>{point.name}</b>: {point.percentage:.1f} %'
//             }
//         }
//     },
//     series: [{
//         name: 'Brands',
//         colorByPoint: true,
//         data: [{
//             name: 'Chrome',
//             y: 61.41,
//             sliced: true,
//             selected: true
//         }, {
//             name: 'Internet Explorer',
//             y: 11.84
//         }, {
//             name: 'Firefox',
//             y: 10.85
//         }, {
//             name: 'Edge',
//             y: 4.67
//         }, {
//             name: 'Safari',
//             y: 4.18
//         }, {
//             name: 'Sogou Explorer',
//             y: 1.64
//         }, {
//             name: 'Opera',
//             y: 1.6
//         }, {
//             name: 'QQ',
//             y: 1.2
//         }, {
//             name: 'Other',
//             y: 2.61
//         }]
//     }]
// });

// document.getElementById('pdf').addEventListener('click', function () {
//     Highcharts.charts[0].exportChart({
//         type: 'image/png'
//     });
// });
</script>
</body>
</html>
