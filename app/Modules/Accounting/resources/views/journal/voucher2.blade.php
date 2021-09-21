<section class="card">
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
                <h2>MONEY RECEIPT</h2>
                <p class="pb-3">Journal NO: #{{ $data->voucher_no }}
                    <br>
                    Journal Date: {{  date("F jS, Y", strtotime($data->date)) }}
                    <br>
                    Journal Type: {{ $data->type }}
                </p>
            </div>
        </div>
        <!--/ Invoice Company Details -->

        <!-- Invoice Customer Details -->
        <div id="invoice-customer-details" class="row pt-2">
            <div class="col-sm-12 text-center text-md-left">
                <p class="text-muted">Journal For:</p>
            </div>
            <div class="col-md-12 col-sm-12 text-center text-md-left">
                <ul class="px-0 list-unstyled">
                    <li class="text-bold-800">{{ $data->reference }}</li>
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
                            <th>Chart of Accounts</th>
                            <th class="text-right">Remarks</th>
                            <th class="text-right">Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total = $amount = 0;
                        ?>
                        @foreach($data->journalDetails as $key => $dt)
                            <?php
                            $amount = $dt->amount;
                            $total += $amount;
                            ?>
                            <tr>
                                <th scope="row" style="width: 2%;">{{ ++$key }}</th>
                                <td>
                                    <p>{{ isset($dt->chartOfAccount->name) ? $dt->chartOfAccount->name : "N/A" }}</p>
                                </td>
                                <td class="text-right" style="text-align: right;">{{ $dt->remarks }}</td>
                                <td class="text-right" style="text-align: right;">{{ number_format($amount, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="3">TOTAL</th>
                            <th style="text-align: right;">{{ number_format($total, 2) }}</th>
                        </tr>
                        <tr>
                            <th colspan="3">NET PAYABLE AMOUNT</th>
                            <th style="text-align: center;" colspan="3">{{ number_format($total, 2) }}</th>
                        </tr>
                        <tr>
                            <td colspan="5">Inword: <span style="text-transform: capitalize; font-weight: bold">
                            <?php
                                $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                                echo $f->format($total);
                            ?> Taka only</span></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>
