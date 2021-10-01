@extends('layouts.app')
@section('title') {{ isset($pageTitle) ? $pageTitle : 'Invoice Preview' }} @endsection
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

        .btext{
            font-size: 16px;
        }

        .ptext{
            font-size: 15px;
        }
        .ttext{
            font-size: 18px;
        }

        .itext{
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
    <section class="card" id="printableArea">
        <div class="container">
            <img class="rounded mx-auto d-block" src="{{ asset('uploads/'. config('settings.site_logo')) }}" style=" position: absolute; left:0; right:0; margin:0 auto; opacity: 0.15;width: 50%; z-index: 9"/>
        <div id="invoice-template" class="card-body">
            <!-- Invoice Company Details -->
            <div id="invoice-company-details" class="row" style="width: 100%;">
                <div class="col-md-6 col-sm-6 col-xs-6 col-6 text-left text-md-left" style="width: 48%; float: left;">
                    <div class="media">
                        <img class="" alt="{{ config('settings.site_name') }}"
                             title="{{ config('settings.site_name') }}"
                             src="{{ asset('uploads/'. config('settings.site_logo')) }}"
                             style="height: 80px; width: 80px;">
                        <div class="media-body itext" style="padding-left:5%;">
                            <ul class="ml-2 px-0 list-unstyled">
                                <li class="text-bold-800">{{config('settings.company_name')}}</li>
                                <li>{{ config('settings.house_no') }} {{ config('settings.road_no') }}</li>
                                <li>{{ config('settings.phone') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 col-6 text-right text-md-right" style="width: 48%; float: left;">
                    <h2>INVOICE</h2>
                    <p class="pb-3 ttext"># {{ $invoice->invoice_no }}</p>
                </div>
            </div>
            <hr>
            <!--/ Invoice Company Details -->

            <!-- Invoice Customer Details -->
            <div id="invoice-customer-details" class="row btext" style="width:100%;">
                <div class="" style="width:50%;">
                <div class="col-md-12 col-sm-12 text-left text-md-left" style="width:30%;">
                    <p class="">Bill To</p>
                </div>
                <div class="col-md-12 col-sm-12 text-left text-md-left" style="width:100%;">
                    <ul class="px-0 list-unstyled ">
                        <li class="text-bold-800 text-muted ">Name : {{ $invoice->customer->name }}</li>
                        <li class="text-muted ">Address : {{ $invoice->customer->address }}</li>
                        <li class="text-muted ">Phone : {{ $invoice->customer->contact_no }}</li>
                    </ul>
                </div>
                </div>
                <div class="" style="width:50%;">
                <div class="col-md-12 col-sm-12 text-right text-md-right " style="width:100%; ">
                    <p></p>
                    <p class="">
                        <span
                            class="text-muted">Invoice Date :</span> {{  date("F jS, Y", strtotime($invoice->date)) }}</li>
                    </p>
                    <p class="">
                        <span
                            class="text-muted">Terms :</span> {{  $invoice->cash_credit == \App\Modules\Config\Models\Lookup::CASH ? "CASH" : "DUE" }}
                    </p>
                </div>
                </div>
            </div>
            <!--/ Invoice Customer Details -->
            <!-- Invoice Items Details -->
            <div id="invoice-items-details" class="pt-2">
                <div class="row ptext">
                    <div class="table-responsive col-sm-12">
                        <table class="table bg-transparent" >
                            <thead>
                            <tr>
                                <th style="border-right: solid silver 0.5px;">#</th>
                                <th style="border-right: solid silver 0.5px;">Item & Description</th>
                                <th class="text-right" style="border-right: solid silver 0.5px;">Qty</th>
                                <th class="text-right" style="border-right: solid silver 0.5px;">Sell Price</th>
                                <th class="text-right" style="border-right: solid silver 0.5px;">Amount</th>
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
                                    <th scope="row" style="width: 2%;border-right: solid silver 0.5px;">{{ ++$key }}</th>
                                    <td style="border-right: solid silver 0.5px;">
                                        <p>{{ $invD->product->name}} {!! $invD->sn?'<br><span style="font-size:13px;">IMEI/SN: '.$invD->sn.'</span>':'' !!} </p>
                                        <p class="text-muted">{{ $invD->warranty?$invD->warranty->name:'No Warranty' }}</p>
                                    </td>
                                    <td class="text-right" style="border-right: solid silver 0.5px;">{{ $invD->qty }}</td>
                                    <td class="text-right" style="border-right: solid silver 0.5px;">{{ $invD->sell_price }}</td>
                                    <td class="text-right" style="border-right: solid silver 0.5px;">{{ $invD->row_total }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tr style="border-bottom: 0 !important;">
                                <td colspan="4" class="text-right" style="border-right: solid silver 0.5px;">Total</td>
                                <td class="text-right" style="border-right: solid silver 0.5px;">{{$salesTotal}}</td>
                            </tr>

                        </table>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6 col-sm-6 text-left text-md-left" style="width: 50%;">
                        <?php
                        $total_mr = 0;
                        ?>
                        @if($invoice->cash_credit == \App\Modules\Config\Models\Lookup::CASH)
                            <p class="lead">Payment Methods:</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-borderless">
                                        <tbody>
                                        <?php
                                        $mr_info = \App\Modules\Accounting\Models\MoneyReceipt::mrInfo($id);
                                        $total_mr = \App\Modules\Accounting\Models\MoneyReceipt::totalMrAmountOfInvoice($id);
                                        ?>
                                        @if($invoice->collection_type == \App\Modules\Config\Models\Lookup::PAYMENT_CASH)
                                            <tr>
                                                <td>Payment Method:</td>
                                                <td class="text-left">Cash</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>Bank name:</td>
                                                <td class="text-left">
                                                    {{ \App\Modules\Config\Models\Lookup::item('bank', $mr_info->bank_id) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Cheque/Transaction No:</td>
                                                <td class="text-left">{{ $mr_info->cheque_no }}</td>
                                            </tr>
                                            <tr>
                                                <td>MR no:</td>
                                                <td>{{ $mr_info->mr_no }}</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6 col-sm-6" style="width: 50%;">
                        <p class="lead">Total due</p>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td class="text-bold-800">Total</td>
                                    <td class="text-bold-800 text-right"> <?= number_format($salesTotal, 2) ?></td>
                                </tr>
                                <tr>
                                    <td>Discount</td>
                                    <td class="pink text-right">(-) <?= number_format($invoice->discount_amount, 2) ?></td>
                                </tr>
                                <tr>
                                    <td>Payment Made</td>
                                    <td class="pink text-right">(-) <?= number_format($total_mr, 2) ?></td>
                                </tr>
                                <tr class="bg-grey bg-lighten-4">
                                    <td class="text-bold-800">Balance Due</td>
                                    <td class="text-bold-800 text-right"><?= number_format(($salesTotal - ($total_mr+$invoice->discount_amount)), 2) ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        </div>
    </section>

@endsection
@push('scripts')
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

@endpush
