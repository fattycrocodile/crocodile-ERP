@push('styles')
    <style>

        #salesChart {
            position: relative;
            max-width: 1024px;
            min-width: 320px;
            margin: 0 auto;
        }
    </style>
@endpush

<!-- Stats -->
<div class="row">
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-primary bg-darken-2">
                        <i class="icon-camera font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-gradient-x-primary white media-body">
                        <h5>Products</h5>
                        <h5 class="text-bold-400 mb-0"><i
                                class="ft-plus"></i> {{ number_format(\App\Modules\StoreInventory\Models\Product::totalProductCount()) }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-danger bg-darken-2">
                        <i class="icon-user font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-gradient-x-danger white media-body">
                        <h5>Customer</h5>
                        <h5 class="text-bold-400 mb-0"><i
                                class="ft-arrow-up"></i>{{ number_format(\App\Modules\Crm\Models\Customers::totalCustomerCount()) }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-warning bg-darken-2">
                        <i class="icon-basket-loaded font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-gradient-x-warning white media-body">
                        <h5>Orders</h5>
                        <h5 class="text-bold-400 mb-0"><i
                                class="ft-plus"></i> {{ number_format(\App\Modules\Crm\Models\SellOrder::totalOrderCount()) }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-success bg-darken-2">
                        <i class="icon-wallet font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-gradient-x-success white media-body">
                        <h5>Invoice</h5>
                        <h5 class="text-bold-400 mb-0"><i
                                class="ft-arrow-up"></i> {{ number_format(\App\Modules\Crm\Models\Invoice::totalInvoiceCount()) }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-success bg-darken-2">
                        <i class="icon-users font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-gradient-x-success white media-body">
                        <h5>Total Employee</h5>
                        <h5 class="text-bold-400 mb-0"><i
                                class="ft-plus"></i> {{ number_format(\App\Modules\Hr\Models\Employees::totalEmployees()) }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-secondary bg-darken-2">
                        <i class="icon-user-following font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-secondary white media-body">
                        <h5>Present Today</h5>
                        <h5 class="text-bold-400 mb-0"><i
                                class="ft-arrow-up"></i>{{ number_format(\App\Modules\Hr\Models\Attendance::totalAttendanceOfEmployeeInDate(date('Y-m-d'))) }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-danger bg-darken-2">
                        <i class="icon-user-unfollow font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-gradient-x-danger white media-body">
                        <h5>Employee in Leave</h5>
                        <h5 class="text-bold-400 mb-0"><i
                                class="ft-plus"></i> {{ number_format(\App\Modules\Hr\Models\LeaveApplication::findApprovedLeaveDate(date('Y-m-d'))) }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-info bg-darken-2">
                        <i class="icon-target font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-gradient-x-info white media-body">
                        <h5>Total Store</h5>
                        <h5 class="text-bold-400 mb-0"><i
                                class="ft-arrow-up"></i> {{ number_format(\App\Modules\StoreInventory\Models\Stores::totalStores()) }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Stats -->
<!--Recent Orders & Monthly Salse -->
<div class="row match-height">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Recent Orders</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <p>
                        <span class="float-right"><a href="{{ route('crm.invoice.index') }}" target="_blank">Invoice Summary <i
                                    class="ft-arrow-right"></i></a></span>
                    </p>
                </div>
                <div class="table-responsive">
                    <table id="recent-orders" class="table table-hover mb-0 ps-container ps-theme-default">
                        <thead>
                        <tr>
                            <th>DATE</th>
                            <th>Invoice#</th>
                            <th>Customer Name</th>
                            <th>Store</th>
                            <th>Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($invoice){
                        foreach ($invoice as $inv){
                        ?>
                        <tr>
                            <td class="text-truncate">{{ $inv->date }}</td>
                            <td class="text-truncate"><a href="#">{{ $inv->invoice_no }}</a></td>
                            <td class="text-truncate">{{ $inv->customer->name }}</td>
                            <td class="text-truncate">
                                <span class="badge badge-default badge-success">{{ $inv->store->name }}</span>
                            </td>
                            <td class="text-truncate">{{ number_format($inv->grand_total, 2) }}</td>
                        </tr>
                        <?php
                        }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Yearly Sales Analysis</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
                    <canvas id="salesChart" width="1000px" height="350px"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Order, Sales and Purchase analysis</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collapse show">
                <div class="card-body chartjs">
                    <canvas id="line-stacked-area" height="500"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@php
    $year = date('Y');
    $month = date('m')+1;
    $label = [];
    $data = [];
    $dataOrder = [];
    $dataPurchase = [];
@endphp

@for($i = 0; $i < 12; $i++)
    @php
        $month-=1;
        if($month==0)
            {
                $month = 12;
                $year -=1;
            }
        $monthSales = \App\Modules\Crm\Models\Invoice::monthlySales($year,$month);
        $monthOrders = \App\Modules\Crm\Models\SellOrder::monthlyOrders($year,$month);
        $monthPurchases = \App\Modules\Commercial\Models\Purchase::monthlyPurchase($year,$month);
        $monthOYear = date("M", mktime(0, 0, 0, $month, 10)).'-'.$year;

        array_push($label,$monthOYear);
        array_push($data,$monthSales);
        array_push($dataOrder,$monthOrders);
        array_push($dataPurchase,$monthPurchases);
        $rlabel = array_reverse($label);
        $rdata = array_reverse($data);
        $salesArray = $rdata;
        $ordersArray = array_reverse($dataOrder);
        $purchaseArray = array_reverse($dataPurchase);

    @endphp
@endfor

<!--/Recent Orders & Monthly Salse -->
@push('scripts')

    <script src="{{asset('app-assets/vendors/js/charts/chart.min.js" type="text/javascript')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.js"></script>



    <script type="text/javascript">
        $(window).on("load", function(){

            //Get the context of the Chart canvas element we want to select
            // var ctx = document.getElementById("line-stacked-area").getContext("2d");
            var ctx = $('#line-stacked-area');

            // Chart Options
            var chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                },
                hover: {
                    mode: 'label'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        gridLines: {
                            color: "#f3f3f3",
                            drawTicks: false,
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        gridLines: {
                            color: "#f3f3f3",
                            drawTicks: false,
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        }
                    }]
                },
                title: {
                    display: true,
                    text: 'Order, Sales and Purchase Analysis'
                }
            };

            // Chart Data
            var chartData = {
                labels: <?php echo json_encode($rlabel); ?>,
                datasets: [{
                    label: "Orders",
                    data: <?php echo json_encode($ordersArray); ?>,
                    backgroundColor: "rgba(22,211,154,.5)",
                    borderColor: "transparent",
                    pointBorderColor: "#16D39A",
                    pointBackgroundColor: "#FFF",
                    pointBorderWidth: 2,
                    pointHoverBorderWidth: 2,
                    pointRadius: 4,
                }, {
                    label: "Sales",
                    data: <?php echo json_encode($salesArray); ?>,
                    backgroundColor: "rgba(81,117,224,.5)",
                    borderColor: "transparent",
                    pointBorderColor: "#5175E0",
                    pointBackgroundColor: "#FFF",
                    pointBorderWidth: 2,
                    pointHoverBorderWidth: 2,
                    pointRadius: 4,
                }, {
                    label: "Purchases",
                    data: <?php echo json_encode($purchaseArray); ?>,
                    backgroundColor: "rgba(249,142,118,.5)",
                    borderColor: "transparent",
                    pointBorderColor: "#F98E76",
                    pointBackgroundColor: "#FFF",
                    pointBorderWidth: 2,
                    pointHoverBorderWidth: 2,
                    pointRadius: 4,
                }]
            };

            var config = {
                type: 'line',

                // Chart Options
                options : chartOptions,

                // Chart Data
                data : chartData
            };

            // Create the chart
            var stackedAreaChart = new Chart(ctx, config);
        });
    </script>







    <script type="text/javascript">

        var ctx = document.getElementById("salesChart");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($rlabel); ?>,
                datasets: [{
                    label: 'Sales',
                    data: <?php echo json_encode($rdata); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.4)',
                        'rgba(54, 162, 235, 0.4)',
                        'rgba(255, 206, 86, 0.4)',
                        'rgba(75, 192, 192, 0.4)',
                        'rgba(153, 102, 255, 0.4)',
                        'rgba(255, 159, 64, 0.4)',
                        'rgba(255, 99, 132, 0.4)',
                        'rgba(54, 162, 235, 0.4)',
                        'rgba(255, 206, 86, 0.4)',
                        'rgba(75, 192, 192, 0.4)',
                        'rgba(153, 102, 255, 0.4)',
                        'rgba(255, 159, 64, 0.4)',
                        'rgba(255, 99, 132, 0.4)',
                        'rgba(54, 162, 235, 0.4)',
                        'rgba(255, 206, 86, 0.4)',
                        'rgba(75, 192, 192, 0.4)',
                        'rgba(153, 102, 255, 0.4)',
                        'rgba(255, 159, 64, 0.4)',
                        'rgba(255, 99, 132, 0.4)',
                        'rgba(54, 162, 235, 0.4)',
                        'rgba(255, 206, 86, 0.4)',
                        'rgba(75, 192, 192, 0.4)',
                        'rgba(153, 102, 255, 0.4)',
                        'rgba(255, 159, 64, 0.4)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                "hover": {
                    "animationDuration": 0
                },
                "animation": {
                    "duration": 1,
                    "onComplete": function () {
                        var chartInstance = this.chart,
                            ctx = chartInstance.ctx;

                        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                        ctx.textAlign = 'center';
                        ctx.fillStyle = "red";
                        ctx.textBaseline = 'bottom';

                        this.data.datasets.forEach(function (dataset, i) {
                            var meta = chartInstance.controller.getDatasetMeta(i);
                            meta.data.forEach(function (bar, index) {
                                var data = dataset.data[index];
                                ctx.fillText(data.toFixed(2), bar._model.x, bar._model.y - 5);
                            });
                        });
                    }
                },
                legend: {
                    "display": false
                },
                tooltips: {
                    "enabled": false
                },
                scaleFontColor: "#000000",
                scales: {
                    xAxes: [{
                        ticks: {
                            maxRotation: 0,
                            minRotation: 0
                        },
                        gridLines: {
                            offsetGridLines: true // à rajouter
                        }
                    },
                        {
                            position: "top",
                            ticks: {
                                maxRotation: 0,
                                minRotation: 0
                            },
                            gridLines: {
                                offsetGridLines: true // et matcher pareil ici
                            }
                        }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function (value, index, values) {
                                return value + " ";
                            }
                        }
                    }]
                }
            }
        });

    </script>

@endpush
