@extends('layouts.app')
@section('title') {{ isset($pageTitle) ? $pageTitle : 'Invoice Preview' }} @endsection
@push('styles')

@endpush

@section('content')
    @include('inc.flash')
    <div class="btn-group" role="group" aria-label="Basic example">
        <a href="{{ route('commercial.purchase.create') }}" class="btn btn-icon btn-secondary"><i class="fa fa-backward"></i> Go
            Back</a>
        <a href="{{ route('commercial.purchase.index') }}" class="btn btn-icon btn-secondary"><i class="fa fa-list-ul"></i>
            Purchase Manage</a>
        <a href="#" class="btn btn-icon btn-secondary print-btn" onclick="printDiv('printableArea')"><i class="fa fa-print"></i>
            Print</a>
    </div>
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
                    <h2>INVOICE</h2>
                    <p class="pb-3"># {{ $invoice->invoice_no }}</p>
                    {{--                    <ul class="px-0 list-unstyled">--}}
                    {{--                        <li>Balance Due</li>--}}
                    {{--                        <li class="lead text-bold-800">$ 12,000.00</li>--}}
                    {{--                    </ul>--}}
                </div>
            </div>
            <!--/ Invoice Company Details -->

            <!-- Invoice Customer Details -->
            <div id="invoice-customer-details" class="row pt-2">
                <div class="col-sm-12 text-center text-md-left">
                    <p class="text-muted">Purchase From</p>
                </div>
                <div class="col-md-6 col-sm-12 text-center text-md-left">
                    <ul class="px-0 list-unstyled">
                        <li class="text-bold-800">{{ $invoice->supplier->name }}</li>
                        <li>{{ $invoice->supplier->address }}</li>
                    </ul>
                </div>
                <div class="col-md-6 col-sm-12 text-center text-md-right">
                    <p>
                        <span
                            class="text-muted">Invoice Date :</span> {{  date("F jS, Y", strtotime($invoice->date)) }}</li>
                    </p>
                    <p>
                        <span
                            class="text-muted">Terms :</span> {{  $invoice->payment_type == \App\Modules\Config\Models\Lookup::CASH ? "CASH" : "DUE" }}
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
                                <th class="text-right">Purchase Price</th>
                                <th class="text-right">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $salesTotal = 0;
                            ?>
                            @foreach($invoice->purchaseDetails as $key => $invD)
                                <?php
                                $salesTotal += $invD->row_total;
                                ?>
                                <tr>
                                    <th scope="row" style="width: 2%;">{{ ++$key }}</th>
                                    <td>
                                        <p>{{ $invD->product->name }}</p>
                                        <p class="text-muted">{{ $invD->product->code }}</p>
                                    </td>
                                    <td class="text-center">{{ $invD->qty }}</td>
                                    <td class="text-right">{{ $invD->purchase_price }}</td>
                                    <td class="text-right">{{ $invD->row_total }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7 col-sm-12 text-center text-md-left">
                        <?php
                        $total_mr = 0;
                        ?>
                        @if($invoice->payment_type == \App\Modules\Config\Models\Lookup::CASH)
                            <p class="lead">Payment Methods:</p>
                            <div class="row">
                                <div class="col-md-8">
                                    <table class="table table-borderless table-sm">
                                        <tbody>
                                        <?php
                                        $mr_info = \App\Modules\Accounting\Models\SuppliersPayment::mrInfo($id);
                                        $total_mr = \App\Modules\Accounting\Models\SuppliersPayment::totalMrAmountOfInvoice($id);
                                        ?>
                                        @if($mr_info->payment_type == \App\Modules\Config\Models\Lookup::PAYMENT_CASH)
                                            <tr>
                                                <td>Payment Method:</td>
                                                <td class="text-right">Cash</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>Bank name:</td>
                                                <td class="text-right">
                                                    {{ \App\Modules\Config\Models\Lookup::item('bank', $mr_info->bank_id) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Cheque/Transaction No:</td>
                                                <td class="text-right">{{ $mr_info->cheque_no }}</td>
                                            </tr>
                                            <tr>
                                                <td>MR no:</td>
                                                <td class="text-right">{{ $mr_info->pr_no }}</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-5 col-sm-12">
                        <p class="lead">Total due</p>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td class="text-bold-800">Total</td>
                                    <td class="text-bold-800 text-right"> <?= number_format($salesTotal, 2) ?></td>
                                </tr>
                                <tr>
                                    <td>Payment Made</td>
                                    <td class="pink text-right">(-) <?= number_format($total_mr, 2) ?></td>
                                </tr>
                                <tr class="bg-grey bg-lighten-4">
                                    <td class="text-bold-800">Balance Due</td>
                                    <td class="text-bold-800 text-right"><?= number_format(($salesTotal - $total_mr), 2) ?></td>
                                </tr>
                                </tbody>
                            </table>
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
            // var printContents = document.getElementById(divName).innerHTML;
            // var originalContents = document.body.innerHTML;
            //
            // document.body.innerHTML = printContents;
            // window.print();
            // document.body.innerHTML = originalContents;
        }

        $('.print-btn').on("click", function () {
            // $('#printableArea').printThis({
            //     base: "https://jasonday.github.io/printThis/"
            // });

            $("#printableArea").printThis({
                debug: false,               // show the iframe for debugging
                importCSS: true,            // import parent page css
                importStyle: true,         // import style tags
                printContainer: true,       // print outer container/$.selector
                loadCSS: "",                // path to additional css file - use an array [] for multiple
                pageTitle: "",              // add title to print page
                removeInline: false,        // remove inline styles from print elements
                removeInlineSelector: "*",  // custom selectors to filter inline styles. removeInline must be true
                printDelay: 333,            // variable print delay
                header: null,               // prefix to html
                footer: null,               // postfix to html
                base: false,                // preserve the BASE tag or accept a string for the URL
                formValues: true,           // preserve input/form values
                canvas: false,              // copy canvas content
                doctypeString: '...',       // enter a different doctype for older markup
                removeScripts: false,       // remove script tags from print content
                copyTagClasses: false,      // copy classes from the html & body tag
                beforePrintEvent: null,     // function for printEvent in iframe
                beforePrint: null,          // function called before iframe is filled
                afterPrint: null            // function called before iframe is removed
            });

        });


    </script>
@endpush
