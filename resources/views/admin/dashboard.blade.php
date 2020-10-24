@extends('layouts.admin')

@section('css')
    <style>
        svg {
            width: 100%;
        }

        .charts {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }

        .charts > * {
            flex-basis: 30rem;
            margin: .5rem 1rem;
        }

    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-light">
            <h1>Dashboard</h1>
            <div class="row justify-content-center">
                <div class="col-lg-12">
        
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body bg-success">
                                    <div class="row">
                                        <div class="col-lg-10 col-md-10 col-sm-10 col-10"><h3> {{ $totalItemsSold }}</h3></div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-2"><i class="fas fa-shopping-cart"></i></div>
                                    </div>
        
                                    <div class="row">
                                        <div class="col-lg-10 col-md-10 col-sm-10 col-10 align-self-end"><h6>Orders</h6></div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-2 align-self-end"><i class="fas fa-shopping-cart"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body bg-warning">
                                    <div class="row">
                                        <div class="col-lg-10 col-md-10 col-sm-10 col-10"><h3><i class="{{ currencySymbol() }}"></i> {{ number_format($currentYearProfit, 2) }}</h3></div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-2"><i class="fas fa-shopping-cart"></i></div>
                                    </div>
        
                                    <div class="row">
                                        <div class="col-lg-10 col-md-10 col-sm-10 col-10 align-self-end"><h6>Total Revenue</h6></div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-2 align-self-end"><i class="fas fa-shopping-cart"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body bg-primary">
                                    <div class="row">
                                        <div class="col-lg-10 col-md-10 col-sm-10 col-10"><h3>0</h3></div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-2"><i class="fas fa-shopping-cart"></i></div>
                                    </div>
        
                                    <div class="row">
                                        <div class="col-lg-10 col-md-10 col-sm-10 col-10 align-self-end"><h6>0</h6></div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-2 align-self-end"><i class="fas fa-shopping-cart"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body bg-danger">
                                    <div class="row">
                                        <div class="col-lg-10 col-md-10 col-sm-10 col-10"><h3><i class="{{ currencySymbol() }}"></i> 100,000</h3></div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-2"><i class="fas fa-shopping-cart"></i></div>
                                    </div>
        
                                    <div class="row">
                                        <div class="col-lg-10 col-md-10 col-sm-10 col-10 align-self-end"><h6>Liabilites</h6></div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-2 align-self-end"><i class="fas fa-shopping-cart"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="charts">
                <div class="card">
                    <div class="card-body">
                        <div id="monthly_sales__container"></div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div id="payments__chart__container"></div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div id="sales__per__day"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script>

        const date = new Date();
        const CURRENT_YEAR = date.getFullYear();
        const PREVIOUS_YEAR = date.getFullYear() - 1;

    (function(){
        orderItemsChart();
        paymentsChart();
        salesPerDay();
        function orderItemsChart ()
        {
            let currentYear = <?php echo json_encode($orderedItemsPerMonth_currentYear) ?>.map((year) => parseInt(year));
            let previousYear = <?php echo json_encode($orderedItemsPerMonth_previousYear) ?>.map((year) => parseInt(year));
            Highcharts.chart('monthly_sales__container', {
                chart: {
                    type: 'column'
                },
                title: 
                {
                    text: 'Monthly Sales Volume ' + CURRENT_YEAR
                },
                subtitle: 
                {
                    text: 'Source: StoryTime'
                },
                xAxis: 
                {
                    categories: 
                        [
                            'Jan', 
                            'Feb', 
                            'March', 
                            'April', 
                            'May', 
                            'June', 
                            'July', 
                            'August', 
                            'September', 
                            'October', 
                            'November', 
                            'December'
                        ],
                        title: 
                        {
                            text: 'Months'
                        }
                },
                yAxis: 
                {
                    min: 0,
                    title: 
                    {
                        text: 'Quantity (pcs)'
                    }
                },
                tooltip: {
                    headerFormat: `<span>Number of Sales</span>
                                <table>`,
                    pointFormat: `      <tr>` +
                                            `<td style="padding:0">
                                                <b>${window.APP.currency_symbol} {point.y: .1f} </b>
                                            </td>
                                        </tr>`,
                    footerFormat: `</table>`,
                    shared: true,
                    useHTML: true
                },
                legend: 
                {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle'
                },
                plotOptions: {
                    series: { allowPointSelect: true },
                    column: {
                        dataLabels: {
                            enabled: true,
                            crop: false,
                            overflow: 'none',
                            maxPadding:0.1,
                            formatter: function()
                            {
                                return this.y || '';
                            }
                        }
                    }
                },
                series: 
                [
                    {
                        name: PREVIOUS_YEAR,
                        data : previousYear

                    }
                    ,
                    {
                        name: CURRENT_YEAR,
                        data : currentYear
                    }
                ],
                responsive: 
                {
                    rules: [
                        {
                            condition: 
                            {
                                maxWidth: 100
                            },
                            chartOptions: 
                            {
                                legend: 
                                {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }
                    ]
                }
            });
        }

        function paymentsChart ()
        {

            let previousYear = <?php echo json_encode($paymentsPerMonth_previousYear) ?>.map((year) => parseInt(year));
            let currentYear = <?php echo json_encode($paymentsPerMonth_currentYear) ?>.map((year) => parseInt(year));

            Highcharts.chart('payments__chart__container', {
                title: 
                {
                    text: 'Monthly Revenue ' + CURRENT_YEAR
                },
                subtitle: 
                {
                    text: 'Source: StoryTime'
                },
                xAxis: 
                {
                    categories: 
                        [
                            'Jan', 
                            'Feb', 
                            'March', 
                            'April', 
                            'May', 
                            'June', 
                            'July', 
                            'August', 
                            'September', 
                            'October', 
                            'November', 
                            'December'
                        ],
                        title: 
                        {
                            text: 'Months'
                        }
                },
                yAxis: 
                {
                    min: 0,
                    title: 
                    {
                        text: `Revenue (${ window.APP.currency_symbol })`
                    }
                },
                tooltip: {
                    headerFormat: `<span>Revenue</span>
                                <table>`,
                    pointFormat: `      <tr>` +
                                            `<td style="padding:0">
                                                <b>${window.APP.currency_symbol} {point.y: .1f} </b>
                                            </td>
                                        </tr>`,
                    footerFormat: `</table>`,
                    shared: true,
                    useHTML: true
                },
                legend: 
                {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle'
                },
                plotOptions: {
                    series: { allowPointSelect: true },
                    line: {
                        dataLabels: {
                            enabled: true,
                            crop: false,
                            overflow: 'none',
                            maxPadding:0.1,
                            formatter: function()
                            {
                                return this.y || '';
                            }
                        }
                    }
                },
                series: 
                [
                    {
                        name: PREVIOUS_YEAR,
                        data : previousYear

                    }
                    ,
                    {
                        name: CURRENT_YEAR,
                        data : currentYear
                    }
                ],
                responsive: 
                {
                    rules: [
                        {
                            condition: 
                            {
                                maxWidth: 100
                            },
                            chartOptions: 
                            {
                                legend: 
                                {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }
                    ]
                }
            });
        }

        function salesPerDay ()
        {
            let salesPerDay = <?php echo json_encode($salesPerDay) ?>.map(sale => parseInt(sale));
            Highcharts.chart('sales__per__day', {
                chart: {
                    type: 'column'
                },
                title: 
                {
                    text: 'Daily Sales Volume' + CURRENT_YEAR
                },
                subtitle: 
                {
                    text: 'Source: StoryTime'
                },
                xAxis: 
                {
                    categories: 
                        [
                            'Monday', 
                            'Tuesday', 
                            'Wednesday', 
                            'Thursday', 
                            'Friday', 
                            'Saturday', 
                            'Sunday'
                        ],
                        title: 
                        {
                            text: 'Days'
                        }
                },
                yAxis: 
                {
                    min: 0,
                    title: 
                    {
                        text: 'Quantity (pcs)'
                    }
                },
                tooltip: {
                    headerFormat: `<span>Sales</span>
                                <table>`,
                    pointFormat: `      <tr>` +
                                            `<td style="padding:0">
                                                <b> {point.y: .1f} </b>
                                            </td>
                                        </tr>`,
                    footerFormat: `</table>`,
                    shared: true,
                    useHTML: true
                },
                legend: 
                {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle'
                },
                plotOptions: {
                    series: { allowPointSelect: true },
                    column: {
                        dataLabels: {
                            enabled: true,
                            crop: false,
                            overflow: 'none',
                            maxPadding:0.1,
                            formatter: function()
                            {
                                return this.y || '';
                            }
                        }
                    }
                },
                series: 
                [{ 
                    name:   'Sales',
                    data : salesPerDay 
                }],
                responsive: 
                {
                    rules: [
                        {
                            condition: 
                            {
                                maxWidth: 100
                            },
                            chartOptions: 
                            {
                                legend: 
                                {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }
                    ]
                }
            });
        }

    }())

    </script>
@endsection