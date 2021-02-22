@extends('layouts.app')
@section('title') {{ isset($pageTitle) ? $pageTitle : 'Order Preview' }} @endsection
@push('styles')

@endpush

@section('content')
    @include('inc.flash')
<div class="btn-group" role="group" aria-label="Basic example">
    <a href="{{ route('crm.sales.order.index') }}" class="btn btn-icon btn-secondary"><i class="fa fa-backward"></i> Go Back</a>
    <a href="{{ route('crm.sales.order.index') }}" class="btn btn-icon btn-secondary"><i class="fa fa-list-ul"></i> Order Manage</a>
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
                    <p class="pb-3"># {{ $order->invoice_no }}</p>
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
                        <li class="text-bold-800">{{ $order->customer->name }}</li>
                        <li>{{ $order->customer->address }}</li>
                    </ul>
                </div>
                <div class="col-md-6 col-sm-12 text-center text-md-right">
                    <p>
                        <span
                            class="text-muted">Invoice Date :</span> {{  date("F jS, Y", strtotime($order->date)) }}</li>
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
                            @foreach($order->sellOrderDetails as $key => $details)
                                <?php
                                $salesTotal += $details->row_total;
                                ?>
                                <tr>
                                    <th scope="row" style="width: 2%;">{{ ++$key }}</th>
                                    <td>
                                        <p>{{ $details->product->name }}</p>
                                        <p class="text-muted">{{ $details->product->code }}</p>
                                    </td>
                                    <td class="text-center">{{ $details->qty }}</td>
                                    <td class="text-right">{{ $details->sell_price }}</td>
                                    <td class="text-right">{{ $details->row_total }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <th class="text-bold-800 text-right" >Total</th>
                                    <th class="text-bold-800 text-right"> <?= number_format($salesTotal, 2) ?></th>
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
