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
                <h2>PAYMENT RECEIPT</h2>
                <p class="pb-3">PR NO: #{{ $data->first()->pr_no }}
                    <br>
                    PR Date: {{  date("F jS, Y", strtotime($data->first()->date)) }}
                </p>
            </div>
        </div>
        <!--/ Invoice Company Details -->

        <!-- Invoice Customer Details -->
        <div id="invoice-customer-details" class="row pt-2">
            <div class="col-sm-12 text-center text-md-left">
                <p class="text-muted">Supplier:</p>
            </div>
            <div class="col-md-12 col-sm-12 text-center text-md-left">
                <ul class="px-0 list-unstyled">
                    <li class="text-bold-800">{{ $data->first()->supplier->name }}</li>
                    <li>{{ $data->first()->supplier->address }}</li>
                </ul>
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
                            <th>Purchase Order No</th>
                            <th class="text-right">Amount</th>
                            <th class="text-right">Discount</th>
                            <th class="text-right">Row Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total = $rcvAmount = $disAmount = 0;
                        ?>
                        @foreach($data as $key => $dt)
                            <?php
                            $amount = $dt->amount;
                            $discount = $dt->discount;
                            $rowTotal = $amount + $discount;
                            $rcvAmount += $amount;
                            $disAmount += $discount;
                            $total += $rowTotal;
                            ?>
                            <tr>
                                <th scope="row" style="width: 2%;">{{ ++$key }}</th>
                                <td>
                                    <p>{{ isset($dt->purchase->invoice_no) ? $dt->purchase->invoice_no : "N/A" }}</p>
                                </td>
                                <td class="text-right" style="text-align: right;">{{ number_format($amount, 2) }}</td>
                                <td class="text-right" style="text-align: right;">{{ number_format($discount, 2) }}</td>
                                <td class="text-right" style="text-align: right;">{{ number_format($total, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="2">TOTAL</th>
                            <th style="text-align: right;">{{ number_format($rcvAmount, 2) }}</th>
                            <th style="text-align: right;">{{ number_format($disAmount, 2) }}</th>
                            <th></th>
                        </tr>
                        <tr>
                            <th colspan="2">NET PAID AMOUNT</th>
                            <th style="text-align: center;" colspan="2">{{ number_format($rcvAmount, 2) }}</th>
                        </tr>
                        <tr>
                            <td colspan="5">Inword: <span style="text-transform: capitalize; font-weight: bold">
                            <?php
                                $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                                echo $f->format($rcvAmount);
                            ?> Taka only</span></td>
                        </tr>
                        </tfoot>
                    </table>
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
