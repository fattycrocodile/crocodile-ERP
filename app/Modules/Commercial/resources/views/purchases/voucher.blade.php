@extends('layouts.app')
@section('title') {{ isset($pageTitle) ? $pageTitle : 'Invoice Preview' }} @endsection
@push('styles')

@endpush

@section('content')
    @include('inc.flash')
<div class="btn-group" role="group" aria-label="Basic example">
    <a href="{{ route('crm.invoice.create') }}" class="btn btn-icon btn-secondary"><i class="fa fa-backward"></i> Go Back</a>
    <a href="{{ route('crm.invoice.index') }}" class="btn btn-icon btn-secondary"><i class="fa fa-list-ul"></i> Invoice Manage</a>
    <a href="#" class="btn btn-icon btn-secondary"><i class="fa fa-print"></i> Print</a>
</div>
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
                    <p class="text-muted">Bill To</p>
                </div>
                <div class="col-md-6 col-sm-12 text-center text-md-left">
                    <ul class="px-0 list-unstyled">
                        <li class="text-bold-800">{{ $invoice->customer->name }}</li>
                        <li>{{ $invoice->customer->address }}</li>
                    </ul>
                </div>
                <div class="col-md-6 col-sm-12 text-center text-md-right">
                    <p>
                        <span
                            class="text-muted">Invoice Date :</span> {{  date("F jS, Y", strtotime($invoice->date)) }}</li>
                    </p>
                    <p>
                        <span
                            class="text-muted">Terms :</span> {{  $invoice->cash_credit == \App\Modules\Config\Models\Lookup::CASH ? "CASH" : "DUE" }}
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
                                <th class="text-right">Sell Price</th>
                                <th class="text-right">Amount</th>
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
                                    <th scope="row" style="width: 2%;">{{ ++$key }}</th>
                                    <td>
                                        <p>{{ $invD->product->name }}</p>
                                        <p class="text-muted">{{ $invD->product->code }}</p>
                                    </td>
                                    <td class="text-center">{{ $invD->qty }}</td>
                                    <td class="text-right">{{ $invD->sell_price }}</td>
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
                        @if($invoice->cash_credit == \App\Modules\Config\Models\Lookup::CASH)
                            <p class="lead">Payment Methods:</p>
                            <div class="row">
                                <div class="col-md-8">
                                    <table class="table table-borderless table-sm">
                                        <tbody>
                                        <?php
                                        $mr_info = \App\Modules\Accounting\Models\MoneyReceipt::mrInfo($id);
                                        $total_mr = \App\Modules\Accounting\Models\MoneyReceipt::totalMrAmountOfInvoice($id);
                                        ?>
                                        @if($invoice->collection_type == \App\Modules\Config\Models\Lookup::PAYMENT_CASH)
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
                                                <td class="text-right">{{ $mr_info->mr_no }}</td>
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

@endpush
