@extends('layouts.app')
@section('title') {{ isset($pageTitle) ? $pageTitle : 'Invoice Preview' }} @endsection
@push('styles')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"
          media="all">
    <style type="text/css">

        @media print {
            * {
                font-family: 'Roboto', sans-serif;
            }

            body {
                margin: 0;
                color: #000;
                background-color: #fff;
                width: 400px;
            }

            table tr td {
                background-color: transparent;
            }
        }

        body {
            font-family: 'Roboto', sans-serif;
        }

        table thead tr th {
            background-color: transparent;
            border: 0.5px solid black !important;
        }

        table tbody tr td {
            background-color: transparent;
            border: 0.5px solid black !important;
        }

        .btext {
            font-size: 16px;
        }

        .ptext {
            font-size: 15px;
        }

        .ttext {
            font-size: 18px;
        }

        .itext {
            font-size: 20px;
        }

    </style>
@endpush

@section('content')
    @include('inc.flash')
    <div class="btn-group" role="group" aria-label="Basic example">
        <a href="{{ route('crm.invoice.create') }}" class="btn btn-icon btn-secondary"><i class="fa fa-backward"></i> Go
            Back</a>
        <a href="{{ route('crm.invoice.index') }}" class="btn btn-icon btn-secondary"><i class="fa fa-list-ul"></i>
            Invoice Manage</a>
        <a href="#" class="btn btn-icon btn-secondary" onclick="printDiv('printableArea')"><i class="fa fa-print"></i>
            Print</a>
    </div>
    <section class="card" id="printableArea" style="width: 450px; top: 0;padding-left: 5px;">
        <div class="container">
        <!--            <img class="rounded mx-auto d-block" src="{{ asset('uploads/'. config('settings.site_logo')) }}"
                 style=" position: absolute; left:0; right:0; top: 50px; margin:0 auto; opacity: 0.15;width: 50%; z-index: 9"/>-->
            <div id="invoice-template">
                <!-- Invoice Company Details -->
                <div id="invoice-company-details" style="width: 350px;">
                    <div class="col-md-12">
                        <div>
                            <div style="text-align: center; width: 350px;">
                                <img class="" alt="{{ config('settings.site_name') }}"
                                     title="{{ config('settings.site_name') }}"
                                     src="{{ asset('uploads/'. config('settings.site_logo')) }}"
                                     style=" width: 150pt;">
                            </div>
                            <div class="" style="padding-left:5%;text-align: center; width:350px;">
                                <ul class="list-unstyled">
                                    <li style="font-size: 16pt;font-weight: bold;">{{config('settings.company_name')}}</li>
                                    <li style="font-size: 14pt;">{{ config('settings.house_no') }}
                                        <br>{{ config('settings.road_no') }}</li>
                                    <li style="font-size: 14pt;">{{ config('settings.phone') }}</li>
                                    <li style="font-size: 14pt;">{{ config('settings.phone_2') }}</li>
                                    <li style="font-size: 14pt;">www.ssbleather.com</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Invoice Company Details -->
            <?php
            $mr_info = \App\Modules\Accounting\Models\MoneyReceipt::mrInfo($id);
            ?>
            <!-- Invoice Customer Details -->
                <div id="invoice-customer-details" style="width:350px;">
                    <div class="">
                        <div class="col-md-12 col-sm-12 text-left">
                            <p style="font-size: 14pt;"><b>Bill Info</b></p>
                        </div>
                        <div class="col-md-12 col-sm-12 text-left text-md-left">
                            <ul class="px-0 list-unstyled ">
                                <li style="font-size: 14pt;">Bill No : {{ $invoice->invoice_no }}</li>
                                <li style="font-size: 14pt;">Bill Date
                                    : {{  date("F jS, Y", strtotime($invoice->date)) }}</li>
                                <li style="font-size: 14pt;">Name : {{ $invoice->customer->name }}</li>
                                <li style="font-size: 14pt;">Address : {{ $invoice->customer->address }}</li>
                                <li style="font-size: 14pt;">Phone : {{ $invoice->customer->contact_no }}</li>
                                <li style="font-size: 14pt;">Payment
                                    Terms: {{  $invoice->cash_credit == \App\Modules\Config\Models\Lookup::CASH ? "CASH" : "DUE" }}</li>
                                @if($mr_info->collection_type == \App\Modules\Config\Models\Lookup::PAYMENT_CASH || $mr_info->collection_type == \App\Modules\Config\Models\Lookup::PAYMENT_BKASH)
                                    <li style="font-size: 14pt;">Payment
                                        Via: {{ \App\Modules\Config\Models\Lookup::item('payment_method', $mr_info->collection_type) }}</li>
                                @else
                                    <li style="font-size: 14pt;">Payment
                                        Via: {{ \App\Modules\Config\Models\Lookup::item('payment_method', $mr_info->collection_type) }}</li>
                                    <li style="font-size: 14pt;">Bank
                                        Name: {{ \App\Modules\Config\Models\Lookup::item('bank', $mr_info->bank_id) }}</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <!--/ Invoice Customer Details -->
                <!-- Invoice Items Details -->
                <table class="table" style="width: 350px; font-size: 14pt; margin-left: 20px;">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Items</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Rate</th>
                        <th class="text-right">total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $salesTotal = 0;
                    ?>
                    @foreach($invoice->invoiceDetails as $key => $invD)
                        <?php
                        $salesTotal += $invD->row_total;
                        ?>
                        <tr>
                            <td style="width: 2%;">{{ ++$key }}</td>
                            <td>
                                <p>{{ $invD->product->code}} </p>
                            </td>
                            <td class="text-right">{{ $invD->qty }}</td>
                            <td class="text-right">{{ $invD->sell_price }}</td>
                            <td class="text-right">{{ $invD->row_total }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" class="text-right">Total</td>
                        <td class="text-right">{{$salesTotal}}</td>
                    </tr>
                    </tbody>

                </table>
                <br>
                <?php
                $total_mr = 0;
                $total_mr = \App\Modules\Accounting\Models\MoneyReceipt::totalMrAmountOfInvoice($id);

                ?>
                <div class="col-md-12">
                    <p style="font-size: 12pt;">Payment Details:</p>
                    <table class="table" style="width: 350px; font-size: 14pt;">
                        <tbody>
                        <tr>
                            <td class="text-bold-800">Total</td>
                            <td class="text-bold-800 text-right"> <?= number_format($salesTotal, 2) ?></td>
                        </tr>
                        <tr>
                            <td>Discount</td>
                            <td class="text-right">(-) <?= number_format($invoice->discount_amount, 2) ?></td>
                        </tr>
                        <tr>
                            <td><b>Payment Made</b></td>
                            <td class="text-right">(-) <b><?= number_format($total_mr, 2) ?></b></td>
                        </tr>
                        <tr class="bg-grey bg-lighten-4">
                            <td class="text-bold-800">Balance Due</td>
                            <td class="text-bold-800 text-right"><?= number_format(($salesTotal - ($total_mr + $invoice->discount_amount)), 2) ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                    <div class="row" style="width:350px; font-size: 10pt; padding: 5px; ">
                        <p style="margin-left: 20px;">Terms & Condition:</p><br>
                        <ol>
                            <li>You may exchange your purchase at only this retail store within 7 days of purchase
                                (fresh).
                            </li>
                            <li>You may exchange your purchase by the same amount of product or more.</li>
                            <li>No claim will be entertained without a valid cash memo.</li>
                            <li>Altered Purchase / any promotional product cannot be exchanged.</li>
                        </ol>
                    </div>
            </div>
    </section>

@endsection
@push('scripts')
    <script src="{{asset('js/printThis.js')}}" type="text/javascript"></script>

    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }

        /*function printDiv(divName) {
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

        }*/

    </script>

@endpush
