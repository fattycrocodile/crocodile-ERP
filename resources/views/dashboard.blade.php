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
                        <h5 class="text-bold-400 mb-0"><i class="ft-plus"></i> {{ number_format(\App\Modules\StoreInventory\Models\Product::totalProductCount()) }}</h5>
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
                        <h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i>{{ number_format(\App\Modules\Crm\Models\Customers::totalCustomerCount()) }}</h5>
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
                        <h5 class="text-bold-400 mb-0"><i class="ft-plus"></i> {{ number_format(\App\Modules\Crm\Models\SellOrder::totalOrderCount()) }}</h5>
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
                        <h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i> {{ number_format(\App\Modules\Crm\Models\Invoice::totalInvoiceCount()) }}</h5>
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
                            <th>SKU</th>
                            <th>Invoice#</th>
                            <th>Customer Name</th>
                            <th>Status</th>
                            <th>Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-truncate">PO-10521</td>
                            <td class="text-truncate"><a href="#">INV-001001</a></td>
                            <td class="text-truncate">Elizabeth W.</td>
                            <td class="text-truncate">
                                <span class="badge badge-default badge-success">Paid</span>
                            </td>
                            <td class="text-truncate">$ 1200.00</td>
                        </tr>
                        <tr>
                            <td class="text-truncate">PO-532521</td>
                            <td class="text-truncate"><a href="#">INV-01112</a></td>
                            <td class="text-truncate">Doris R.</td>
                            <td class="text-truncate">
                                <span class="badge badge-default badge-warning">Overdue</span>
                            </td>
                            <td class="text-truncate">$ 5685.00</td>
                        </tr>
                        <tr>
                            <td class="text-truncate">PO-05521</td>
                            <td class="text-truncate"><a href="#">INV-001012</a></td>
                            <td class="text-truncate">Andrew D.</td>
                            <td class="text-truncate">
                                <span class="badge badge-default badge-success">Paid</span>
                            </td>
                            <td class="text-truncate">$ 152.00</td>
                        </tr>
                        <tr>
                            <td class="text-truncate">PO-15521</td>
                            <td class="text-truncate"><a href="#">INV-001401</a></td>
                            <td class="text-truncate">Megan S.</td>
                            <td class="text-truncate">
                                <span class="badge badge-default badge-success">Paid</span>
                            </td>
                            <td class="text-truncate">$ 1450.00</td>
                        </tr>
                        <tr>
                            <td class="text-truncate">PO-32521</td>
                            <td class="text-truncate"><a href="#">INV-008101</a></td>
                            <td class="text-truncate">Walter R.</td>
                            <td class="text-truncate">
                                <span class="badge badge-default badge-warning">Overdue</span>
                            </td>
                            <td class="text-truncate">$ 685.00</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/Recent Orders & Monthly Salse -->
@push('scripts')

@endpush
