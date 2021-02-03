@extends('layouts.app')
@section('title') {{ isset($pageTitle) ? $pageTitle : 'Create Invoice' }} @endsection

@push('styles')
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/jquery-ui.min.css')}}">
    <style>
        .ui-datepicker {
            z-index: 999 !important;
        }
    </style>
@endpush
@section('content')

    @include('inc.flash')

    <section class="basic-elements">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Information's</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="date">Date</label>
                                        <input type="text" class="form-control @error('date') is-invalid @enderror"
                                               id="date" value="{!! date('Y-m-d') !!}" name="date">
                                        @error('date')
                                        <div class="help-block text-danger">{{ $message }} </div> @enderror
                                    </fieldset>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="store_id">Store</label>
                                        <select id="store_id" name="store_id"
                                                class="select2 form-control @error('store_id') is-invalid @enderror">
                                            <option value="none" selected="">Select Store</option>
                                            @foreach($stores as $key => $store)
                                                <option value="{{ $key }}"> {{ $store }} </option>
                                            @endforeach
                                        </select>
                                        @error('store_id')
                                        <div class="help-block text-danger">{{ $message }} </div> @enderror
                                    </fieldset>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="invoice_no">Invoice</label>
                                        <input type="text" class="form-control" id="invoice_no" readonly disabled
                                               value="Invoice no will auto generate!">
                                    </fieldset>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="customer_name">Customer Name</label>
                                        <input type="text"
                                               class="form-control @error('customer_name') is-invalid @enderror"
                                               id="customer_name">
                                        <input type="hidden"
                                               class="form-control @error('customer_id') is-invalid @enderror"
                                               id="customer_id" name="customer_id">
                                        @error('customer_id')
                                        <div class="help-block text-danger">{{ $message }} </div> @enderror
                                    </fieldset>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="customer_code">Customer Code</label>
                                        <input type="text"
                                               class="form-control @error('customer_code') is-invalid @enderror"
                                               id="customer_code">
                                        @error('customer_code')
                                        <div class="help-block text-danger">{{ $message }} </div> @enderror
                                    </fieldset>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="contact_no">Contact</label>
                                        <input type="text" class="form-control" id="contact_no" readonly disabled
                                               value="">
                                    </fieldset>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="{{asset('js/jquery-ui.min.js')}}" type="text/javascript"></script>

    <!-- Script -->
    <script type="text/javascript">

        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function () {

            // datepicker
            $(function () {
                $("#date").datepicker({
                    // appendText:"(yy-mm-dd)",
                    dateFormat: "yy-mm-dd",
                    altField: "#datepicker",
                    altFormat: "DD, d MM, yy",
                    prevText: "click for previous months",
                    nextText: "click for next months",
                    showOtherMonths: true,
                    selectOtherMonths: true,
                    maxDate: new Date()
                });
            });

            // customer name wise search start
            $("#customer_name").autocomplete({
                minLength: 1,
                autoFocus: true,
                source: function (request, response) {
                    var store_id = $("#store_id").val();
                    $.ajax({
                        url: "{{ route('customerNameAutoComplete') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term,
                            store_id: store_id,
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                focus: function (event, ui) {
                    // console.log(event);
                    // console.log(ui);
                    return false;
                },
                select: function (event, ui) {
                    if (ui.item.value != '' || ui.item.value > 0) {
                        $('#customer_name').val(ui.item.name);
                        $('#customer_code').val(ui.item.code);
                        $('#store_id').val(ui.item.store_id);
                        $('#customer_id').val(ui.item.value);
                        $('#contact_no').val(ui.item.contact_no);
                    } else {
                        resetCustomer();
                    }
                    return false;
                },
            }).data("ui-autocomplete")._renderItem = function (ul, item) {

                var inner_html = '<div>' + item.label + ' (<i>' + item.code + ')</i></div>';
                return $("<li>")
                    .data("item.autocomplete", item)
                    .append(inner_html)
                    .appendTo(ul);
            };
            // customer name wise search end

            // customer name wise search start
            $("#customer_code").autocomplete({
                minLength: 1,
                autoFocus: true,
                source: function (request, response) {
                    console.log('customer_code');
                    var store_id = $("#store_id").val();
                    $.ajax({
                        url: "{{ route('customerCodeAutoComplete') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term,
                            store_id: store_id,
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                focus: function (event, ui) {
                    // console.log(event);
                    // console.log(ui);
                    return false;
                },
                select: function (event, ui) {
                    if (ui.item.value != '' || ui.item.value > 0) {
                        $('#customer_name').val(ui.item.name);
                        $('#customer_code').val(ui.item.code);
                        $('#store_id').val(ui.item.store_id);
                        $('#customer_id').val(ui.item.value);
                        $('#contact_no').val(ui.item.contact_no);
                    } else {
                        resetCustomer();
                    }
                    return false;
                },
            }).data("ui-autocomplete")._renderItem = function (ul, item) {
                var inner_html = '<div>' + item.label + ' (<i>' + item.name + ')</i></div>';
                return $("<li>")
                    .data("item.autocomplete", item)
                    .append(inner_html)
                    .appendTo(ul);
            };
            // customer code wise search end
        });


        function resetCustomer() {
            $('#customer_name').val("");
            $('#customer_code').val("");
            $('#customer_id').val("");
            $('#contact_no').val("");
        }
    </script>
@endpush
