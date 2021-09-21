
@push('styles')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" media="all">
    <style type="text/css">
        @media print
        {
            * {
                -webkit-print-color-adjust:exact;
                color-adjust: exact !important;
            }

            table tr td {
                background-color: transparent;
            }
        }

        table tr td {
            background-color: transparent;
        }
    </style>
@endpush

    <section class="card" id="printableArea">
        <div class="container">
            <img class="rounded mx-auto d-block" src="{{ asset('uploads/'. config('settings.site_logo')) }}" style=" position: absolute; left:0; right:0; margin:0 auto; opacity: 0.25;width: 50%; z-index: 9"/>
        <div id="invoice-template" class="card-body">
            <!-- Invoice Company Details -->
            <div id="invoice-company-details" class="row" style="width: 100%;">
                <div class="col-md-6 col-sm-6 col-xs-6 col-6 text-left text-md-left" style="width: 48%; float: left;">
                    <div class="media">
                        <img class="" alt="{{ config('settings.site_name') }}"
                             title="{{ config('settings.site_name') }}"
                             src="{{ asset('uploads/'. config('settings.site_logo')) }}"
                             style="height: 80px; width: 80px;">
                        <div class="media-body" style="padding-left:5%;">
                            <ul class="ml-2 px-0 list-unstyled">
                                <li class="text-bold-800">{{config('settings.company_name')}}</li>
                                <li>{{ config('settings.house_no') }} {{ config('settings.road_no') }}</li>
                                <li>{{ config('settings.phone') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 col-6 text-right text-md-right" style="width: 48%; float: left;">
                    <h2>PAYMENT RECEIPT</h2>
                    <p class="pb-3">PR NO: #{{ $data->first()->pr_no }}
                        <br>
                        PR Date: {{  date("F jS, Y", strtotime($data->first()->date)) }}
                    </p>
                </div>
            </div>
            <hr>
            <!--/ Invoice Company Details -->

            <!-- Invoice Customer Details -->
            <div id="invoice-customer-details" class="row" style="width:100%;">
                <div class="" style="width:50%;">
                <div class="col-md-12 col-sm-12 text-left text-md-left" style="width:30%;">
                    <p class="">Supplier To:</p>
                </div>
                <div class="col-md-12 col-sm-12 text-left text-md-left" style="width:100%;">
                    <ul class="px-0 list-unstyled">
                        <li class="text-bold-800 text-muted">Name : {{ $data->first()->supplier->name }}</li>
                        <li class="text-muted">Address : {{ $data->first()->supplier->address }}</li>
                        <li class="text-muted">Phone : {{ $data->first()->supplier->contact_no }}</li>
                    </ul>
                </div>
                </div>
            </div>
            <!--/ Invoice Customer Details -->
            <!-- Invoice Items Details -->
            <div id="invoice-items-details" class="pt-2">
                <div class="row">
                    <div class="table-responsive col-sm-12">
                        <table class="table bg-transparent">
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
                                    <td class="text-right" style="text-align: right;">{{ number_format($rowTotal, 2) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="2">TOTAL</th>
                                <th> </th>
                                <th style="text-align: right;">{{ number_format($disAmount, 2) }}</th>
                                <th style="text-align: right;">{{ number_format($rcvAmount, 2) }}</th>
                            </tr>
                            <tr>
                                <th colspan="3">NET PAID AMOUNT</th>
                                <th style="text-align: right;" colspan="4">{{ number_format($rcvAmount, 2) }}</th>
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
        </div>
    </section>


<script src="{{asset('js/printThis.js')}}" type="text/javascript"></script>

    <script>
        function printDiv(divName) {
            $("#printableArea").printThis({
                debug: false,               // show the iframe for debugging
                importCSS: true,            // import parent page css
                importStyle: true,         // import style tags
                printContainer: true,       // print outer container/$.selector
                loadCSS: "app-assets/css/bootstrap.css",                // path to additional css file - use an array [] for multiple
                pageTitle: "",              // add title to print page
                removeInline: false,        // remove inline styles from print elements
                removeInlineSelector: "*",  // custom selectors to filter inline styles. removeInline must be true
                printDelay: 333,            // variable print delay
                header: null,               // prefix to html
                footer: null,               // postfix to html
                base: false,                // preserve the BASE tag or accept a string for the URL
                formValues: true,           // preserve input/form values
                canvas: true,              // copy canvas content
                doctypeString: '...',       // enter a different doctype for older markup
                removeScripts: false,       // remove script tags from print content
                copyTagClasses: false,      // copy classes from the html & body tag
                beforePrintEvent: null,     // function for printEvent in iframe
                beforePrint: null,          // function called before iframe is filled
                afterPrint: null            // function called before iframe is removed
            });

        }

    </script>
