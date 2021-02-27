<section class="card" id="printableArea">
    <div id="invoice-template" class="card-body">
        <!-- Invoice Company Details -->
        <div id="invoice-company-details" class="row">
            <div class="col-md-6 col-sm-12 text-center text-md-left">
                <div class="media">
                    <img class="" alt="{{ config('settings.site_name') }}"
                         title="{{ config('settings.site_name') }}"
                         src="{{ asset('uploads/'. config('settings.site_logo')) }}"
                         style="height: 80px; width: 80px;">
                    <div class="media-body">
                        <ul class="ml-2 px-0 list-unstyled">
                            <li class="text-bold-800">{{config('settings.company_name')}}</li>
                            <li>{{ config('settings.house_no') }}</li>
                            <li>{{ config('settings.road_no') }}</li>
                            <li>{{ config('settings.post_code') }}</li>
                            <li>{{ config('settings.phone') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 text-center text-md-right">
                <h2>Store Transfer</h2>
                <p class="pb-3"># {{ $data->invoice_no }}</p>
            </div>
        </div>
        <!--/ Invoice Company Details -->

        <!-- Invoice Customer Details -->
        <div id="invoice-customer-details" class="row pt-2">
            <div class="col-sm-12 text-center text-md-left">
                <p class="text-muted">Transfer To</p>
            </div>
            <div class="col-md-6 col-sm-12 text-center text-md-left">
                <ul class="px-0 list-unstyled">
                    <li class="text-bold-800">{{ $data->receiveStore->name }}</li>
                    <li>{{ $data->receiveStore->address }}</li>
                </ul>
            </div>
            <div class="col-md-6 col-sm-12 text-center text-md-right">
                <p>
                        <span
                            class="text-muted">Transfer Date :</span> {{  date("F jS, Y", strtotime($data->date)) }}</li>
                </p>
                <p>
                        <span
                            class="text-muted">Status :</span> {{  $data->is_received==\App\Modules\StoreInventory\Models\StoreTransfer::IS_RECEIVED?"Received":"Pending" }}</li>
                </p>
            </div>
        </div>
        <!--/ Invoice Customer Details -->
        <!-- Invoice Items Details -->
        <div id="invoice-items-details" class="pt-2">
            <div class="row">
                <div class="table-responsive col-sm-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Product Code</th>
                            <th class="text-right">Qty</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $transferTotal = 0;
                        ?>
                        @foreach($data->storeTransferDetails as $key => $invD)
                            <?php
                            $transferTotal += $invD->qty;
                            ?>
                            <tr>
                                <th scope="row" style="width: 2%;">{{ ++$key }}</th>
                                <td>
                                    <p>{{ $invD->product->name }}</p>
                                </td>
                                <td>
                                    <p class="text-muted">{{ $invD->product->code }}</p>
                                </td>
                                <td class="text-center">{{ $invD->qty }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <p class="lead">Total Transfer</p>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td class="text-bold-800">Total</td>
                                <td class="text-bold-800 text-right"> <?= number_format($transferTotal) ?> Pcs</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
