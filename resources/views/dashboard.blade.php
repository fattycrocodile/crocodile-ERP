@push('styles')
    <style>

    #salesChart{
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

                </div>
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
                    <canvas id="salesChart" width="1000px" height="350px" ></canvas>
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
        $monthOYear = date("M", mktime(0, 0, 0, $month, 10)).'-'.$year;

        array_push($label,$monthOYear);
        array_push($data,$monthSales);
        $rlabel = array_reverse($label);
        $rdata = array_reverse($data);
    @endphp
@endfor

<!--/Recent Orders & Monthly Salse -->
@push('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.js"></script>


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
                            callback: function(value, index, values) {
                                return value+" ";
                            }
                        }
                    }]
                }
            }
        });

    </script>

@endpush
