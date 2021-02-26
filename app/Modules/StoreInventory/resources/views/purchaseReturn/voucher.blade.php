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
                <h2>Purchase Return</h2>
                <p class="pb-3"># {{ $data->return_no }}</p>
            </div>
        </div>
        <!--/ Invoice Company Details -->

        <!-- Invoice Customer Details -->
        <div id="invoice-customer-details" class="row pt-2">
            <div class="col-sm-12 text-center text-md-left">
                <p class="text-muted">Return To</p>
            </div>
            <div class="col-md-6 col-sm-12 text-center text-md-left">
                <ul class="px-0 list-unstyled">
                    <li class="text-bold-800">{{ $data->supplier->name }}</li>
                    <li>{{ $data->supplier->address }}</li>
                </ul>
            </div>
            <div class="col-md-6 col-sm-12 text-center text-md-right">
                <p>
                        <span
                            class="text-muted">Return Date :</span> {{  date("F jS, Y", strtotime($data->date)) }}</li>
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
                            <th>Item & Description</th>
                            <th class="text-right">Qty</th>
                            <th class="text-right">Return Price</th>
                            <th class="text-right">Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $returnTotal = 0;
                        ?>
                        @foreach($data->purchaseReturnDetails as $key => $invD)
                            <?php
                            $returnTotal += $invD->row_total;
                            ?>
                            <tr>
                                <th scope="row" style="width: 2%;">{{ ++$key }}</th>
                                <td>
                                    <p>{{ $invD->product->name }}</p>
                                    <p class="text-muted">{{ $invD->product->code }}</p>
                                </td>
                                <td class="text-center">{{ $invD->qty }}</td>
                                <td class="text-right">{{ $invD->price }}</td>
                                <td class="text-right">{{ $invD->row_total }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <p class="lead">Total Return</p>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td class="text-bold-800">Total</td>
                                <td class="text-bold-800 text-right"> <?= number_format($returnTotal, 2) ?></td>
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
