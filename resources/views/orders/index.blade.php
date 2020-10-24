@extends('layouts.admin')
@section('title', 'Orders')
@section('content-header', 'Orders')
@section('css')
    <style>
        svg {
            width: 100%;
        }
    </style>
@endsection
{{-- Page Content Actions --}}
@section('content-actions')
    <a href="{{ route('cart.index') }}" class="btn btn-success" title="Add Order">
        OPEN POS
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <form action="{{ route('orders.index') }}" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') ?? old('start_date') }}">
                            </div>
                            <div class="col-md-4">
                                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') ?? old('end_date') }}">
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-outline-primary">Submit</button>
                            </div>
                            <div class="col-md-2">
                                <div class="btn-group">
                                    <div class="btn-group dropleft" role="group">
                                        <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="sr-only">Toggle Dropleft</span>
                                        </button>
                                        <div class="dropdown-menu">
                                            <!-- EXCEL -->
                                            <div class="dropdown-item">
                                                <div class="btn-group dropleft">
                                                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Excel
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <div class="dropdown-item">
                                                            <a href="/admin/export/customer-order-excel?start_date={{ request('start_date') ?? old('end_date') }}&end_date={{ request('end_date') ?? old('end_date') }}" class="btn btn-outline-success btn-block">Partial</a>
                                                        </div>
                                                        <div class="dropdown-item">
                                                            <a href="/admin/export/all-customer-order-excel?start_date={{ request('start_date') ?? old('end_date') }}&end_date={{ request('end_date') ?? old('end_date') }}" class="btn btn-outline-success btn-block">All</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <!-- PDF -->
                                                <div class="btn-group dropleft">
                                                    <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    PDF
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <div class="dropdown-item">
                                                            <a href="/admin/export/customer-order-pdf?start_date={{ request('start_date') ?? old('end_date') }}&end_date={{ request('end_date') ?? old('end_date') }}" class="btn btn-outline-danger btn-block">Partial</a>
                                                        </div>
                                                        <div class="dropdown-item">
                                                            <a href="/admin/export/all-customer-order-pdf?start_date={{ request('start_date') ?? old('end_date') }}&end_date={{ request('end_date') ?? old('end_date') }}" class="btn btn-outline-danger btn-block">All</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <!-- CSV -->
                                                <div class="btn-group dropleft">
                                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    CSV
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <div class="dropdown-item">
                                                            <a href="/admin/export/customer-order-csv?start_date={{ request('start_date') ?? old('end_date') }}&end_date={{ request('end_date') ?? old('end_date') }}" class="btn btn-outline-secondary btn-block">Partial</a>
                                                        </div>
                                                        <div class="dropdown-item">
                                                            <a href="/admin/export/all-customer-order-csv?start_date={{ request('start_date') ?? old('end_date') }}&end_date={{ request('end_date') ?? old('end_date') }}" class="btn btn-outline-secondary btn-block">All</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-secondary">
                                    Export
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="container"></div>
    @include('orders.orders_data')

{{-- Appending urlencoded after each page --}}
    <div class="orders-page-link">
    {{ 
        $orders->appends(
        [
            'start_date' => request('start_date') ?? old('start_date'),
            'end_date' => request('end_date') ?? old('end_date')
        ])->render() 
    }}
    </div>

@endsection

@section('js')
    
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script>

    let chart =  {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Browser market shares in January, 2018'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: [{
                name: 'Costs of Goods',
                y: parseInt(document.querySelector('.total').innerText.slice(1))
            }, {
                name: 'Received Amount',
                y: parseInt(document.querySelector('.totalReceivedAmount').innerText.slice(1))
            }]
        }]
    };

    Highcharts.chart('container', chart);
    document.getElementById('pdf').addEventListener('click', function () {
        Highcharts.charts[0].exportChart({
            type: 'image/png'
        });
    });
</script>
@endsection