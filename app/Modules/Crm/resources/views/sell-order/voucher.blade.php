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
        <a href="{{ route('crm.sales.order.index') }}" class="btn btn-icon btn-secondary"><i class="fa fa-backward"></i>
            Go Back</a>
        <a href="{{ route('crm.sales.order.index') }}" class="btn btn-icon btn-secondary"><i class="fa fa-list-ul"></i>
            Order Manage</a>
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
                        <div class="media-body" style="padding-left:5%;">
                            <ul class="ml-2 px-0 list-unstyled itext">
                                <li class="text-bold-800">{{config('settings.company_name')}}</li>
                                <li>{{ config('settings.house_no') }} {{ config('settings.road_no') }}</li>
                                <li>{{ config('settings.phone') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 col-6 text-right text-md-right" style="width: 48%; float: left;">
                    <h2>SALES ORDER</h2>
                    <p class="pb-3 ttext"># {{ $order->order_no }}</p>
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
                    <ul class="px-0 list-unstyled">
                        <li class="text-bold-800 text-muted">Name : {{ $order->customer->name }}</li>
                        <li class="text-muted">Address : {{ $order->customer->address }}</li>
                        <li class="text-muted">Phone : {{ $order->customer->contact_no }}</li>
                    </ul>
                </div>
                </div>
                <div class="" style="width:50%;">
                <div class="col-md-12 col-sm-12 text-right text-md-right" style="width:100%; ">
                    <p></p>
                    <p>
                        <span
                            class="text-muted">Invoice Date :</span> {{  date("F jS, Y", strtotime($order->date)) }}</li>
                    </p>
                </div>
                </div>
            </div>
            <!--/ Invoice Customer Details -->
            <!-- Invoice Items Details -->
            <div id="invoice-items-details" class="pt-2">
                <div class="row ptext">
                    <div class="table-responsive col-sm-12">
                        <table class="table bg-transparent">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Item & Description</th>
                                <th class="text-right">Qty</th>
                                <th class="text-right">Sell Price</th>
                                <th class="text-right">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $salesTotal = 0;
                            ?>
                            @foreach($order->sellOrderDetails as $key => $invD)
                                <?php
                                $salesTotal += $invD->row_total;
                                ?>
                                <tr>
                                    <th scope="row" style="width: 2%;">{{ ++$key }}</th>
                                    <td>
                                        <p>{{ $invD->product->name }}</p>
                                        <p class="text-muted">{{ $invD->warranty?$invD->warranty->name:'No Warranty' }}</p>
                                    </td>
                                    <td class="text-center">{{ $invD->qty }}</td>
                                    <td class="text-right">{{ $invD->sell_price }}</td>
                                    <td class="text-right">{{ $invD->row_total }}</td>
                                </tr>
                            @endforeach
                            </tbody>

                            <tr style="border-bottom: 0 !important;">
                                <td colspan="4" class="text-right">Total</td>
                                <td class="text-right">{{$salesTotal}}</td>
                            </tr>

                        </table>
                    </div>
                </div>
                <br>

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
