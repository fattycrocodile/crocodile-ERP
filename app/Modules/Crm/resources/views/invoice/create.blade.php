@extends('layouts.app')
@section('title') {{ isset($pageTitle) ? $pageTitle : 'Create Invoice' }} @endsection

@push('styles')
    <!-- CSS -->
    <style>
        .ui-datepicker {
            z-index: 999 !important;
        }

        .cash_payment, .bank_other_payment, .cash_payment_bank {
            display: none;
        }

        .col-1-5 {
            flex: 0 0 12.3%;
            max-width: 12.3%;
            position: relative;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }

    </style>
@endpush
@section('content')

    @include('inc.flash')

    <div class="modal fade" id="demoModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">Create new Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form" id="customer-form" method="post">
                <div class="modal-body">
                        @csrf
                        <div class="form-body">
                            <div class="form-group">
                                <label for="customerName">Customer Name</label>
                                <input type="text" id="customerName" class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Customer Name" value="{{ old('name') }}"
                                       name="name">
                                @error('name')<div class="help-block text-danger">{{ $message }} </div> @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="customerContact">Customer Contact</label>
                                        <input type="text" id="customerContact" class="form-control @error('contact_no') is-invalid @enderror"
                                               placeholder="Customer Contact" value="{{ old('contact_no') }}"
                                               name="contact_no">
                                        @error('contact_no')<div class="help-block text-danger">{{ $message }} </div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="store" >Store</label>
                                        <select id="store" name="store" class="select2 form-control @error('store_id') is-invalid @enderror">
                                            <option value="none" selected="" disabled="">Select Store</option>
                                            @foreach($stores as $store)
                                                <option value="{{$store->id}}" {{$store->id==(old('store_id')?old('store_id'):1)?'selected':''}}>{{$store->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('store_id')<div class="help-block text-danger">{{ $message }} </div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address">Customer Address</label>
                                <textarea id="address" rows="5" class="form-control @error('address') is-invalid @enderror" name="address"
                                          placeholder="Customer Address">{{ old('address') }}</textarea>
                                @error('address')<div class="help-block text-danger">{{ $message }} </div> @enderror
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="savecustomer" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <section id="basic-form-layouts">
        <div class="row match-height">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-form">Invoice Info</h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                <li><a data-action="close"><i class="ft-x"></i></a></li>
                            </ul>
                            <button type="button" class="btn btn-primary m-2" data-toggle="modal" data-target="#demoModal">Create Customer</button>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <div class="card-text">
                            </div>
                            <form class="form" id="invoice-form" action="{{route('crm.invoice.store')}}" method="post" autocomplete="off">
                                @csrf
                                <div class="form-body">
                                    <h4 class="form-section"><i class="ft-user"></i> Order & Customer Info</h4>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="date">Date</label>
                                                <input type="text"
                                                       class="form-control @error('date') is-invalid @enderror"
                                                       id="date" value="{!! date('Y-m-d') !!}" name="date" required>
                                                @error('date')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="store_id">Store</label>
                                                <select id="store_id" name="store_id" required
                                                        class="select2 form-control @error('store_id') is-invalid @enderror">
                                                    <option value="none" selected="">Select Store</option>
                                                    @foreach($stores as $key => $store)
                                                        <option value="{{ $store->id }}"> {{ $store->name }} </option>
                                                    @endforeach
                                                </select>
                                                @error('store_id')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="customer_name">Customer Name</label>
                                                <input type="text"
                                                       class="form-control @error('customer_name') is-invalid @enderror"
                                                       id="customer_name" required>
                                                <input type="hidden"
                                                       class="form-control @error('customer_id') is-invalid @enderror"
                                                       id="customer_id" name="customer_id" required>
                                                @error('customer_id')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="customer_code">Customer Code</label>
                                                <input type="text"
                                                       class="form-control @error('customer_code') is-invalid @enderror"
                                                       id="customer_code">
                                                @error('customer_code')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="contact_no">Contact</label>
                                                <input type="text" class="form-control" id="contact_no" value="">
                                            </div>
                                        </div>
                                    </div>


                                    <h4 class="form-section"><i class="fa fa-paperclip"></i> Payment Information</h4>

                                    <div class="row">

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="cash_credit">Cash/Credit</label>
                                                <select id="cash_credit" name="cash_credit" required
                                                        class="select2 form-control @error('cash_credit') is-invalid @enderror">
                                                    <option value="" selected="">Select Cash/Credit</option>
                                                    @foreach($cash_credit as $key => $value)
                                                        <option value="{{ $key }}"> {{ $value }} </option>
                                                    @endforeach
                                                </select>

                                                @error('cash_credit')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-2 cash_payment">
                                            <div class="form-group">
                                                <label for="payment_method">Payment Method</label>
                                                <select id="payment_method" name="payment_method"
                                                        class="select2 form-control @error('payment_method') is-invalid @enderror">
                                                    <option value="none" selected="">Select Payment method</option>
                                                    @foreach($payment_type as $key => $value)
                                                        <option value="{{ $key }}"> {{ $value }} </option>
                                                    @endforeach
                                                </select>
                                                @error('payment_method')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-2 bank_other_payment">
                                            <div class="form-group">
                                                <label for="bank_id">Bank</label>
                                                <select id="bank_id" name="bank_id"
                                                        class="select2 form-control @error('bank_id') is-invalid @enderror">
                                                    <option value="none" selected="">Select Bank</option>
                                                    @foreach($bank as $key => $bnk)
                                                        <option value="{{ $key }}"> {{ $bnk }} </option>
                                                    @endforeach
                                                </select>
                                                @error('bank_id')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-2 bank_other_payment">
                                            <div class="form-group">
                                                <label for="cheque_no">Cheque/Transaction No</label>
                                                <input type="text"
                                                       class="form-control @error('cheque_no') is-invalid @enderror"
                                                       id="cheque_no" name="cheque_no">
                                                @error('cheque_no')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2 bank_other_payment">
                                            <div class="form-group">
                                                <label for="cheque_date">Cheque Date</label>
                                                <input type="text"
                                                       class="form-control @error('cheque_date') is-invalid @enderror"
                                                       id="cheque_date" name="cheque_date">
                                                @error('cheque_date')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2 cash_payment">
                                            <div class="form-group">
                                                <label for="manual_mr_no">Manual MR No</label>
                                                <input type="text"
                                                       class="form-control @error('mr_no') is-invalid @enderror"
                                                       id="manual_mr_no" name="manual_mr_no">
                                                @error('manual_mr_no')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                    </div>


                                    <h4 class="form-section"><i class="fa fa-paperclip"></i> Product Information</h4>

                                    <div class="row">

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="product_name">Product Name</label>
                                                <input type="text"
                                                       class="form-control @error('product_id') is-invalid @enderror"
                                                       id="product_name" name="product_name">
                                                <input type="hidden" name="product_id" id="product_id">
                                                @error('product_id')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-1-5">
                                            <div class="form-group">
                                                <label for="product_code">Product Code</label>
                                                <input type="text"
                                                       class="form-control @error('product_id') is-invalid @enderror"
                                                       id="product_code" name="product_code">
                                                @error('product_id')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label for="qty">Qty</label>
                                                <input type="text"
                                                       class="form-control @error('qty') is-invalid @enderror"
                                                       id="qty" name="qty" onkeyup="calculateTotal();">
                                                @error('qty')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label for="stock_qty">Stock Qty</label>
                                                <input type="text"
                                                       class="form-control @error('stock_qty') is-invalid @enderror"
                                                       id="stock_qty" name="stock_qty" readonly>
                                                @error('stock_qty')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label for="sell_price">Sell Price</label>
                                                <input type="text"
                                                       class="form-control @error('sell_price') is-invalid @enderror"
                                                       id="sell_price" name="sell_price" onkeyup="calculateTotal();">

                                                <input type="hidden" id="min_sell_price">
                                                @error('sell_price')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-1-5">
                                            <div class="form-group">
                                                <label for="total_sell_price">Total Sell Price</label>
                                                <input type="text"
                                                       class="form-control @error('total_sell_price') is-invalid @enderror"
                                                       id="total_sell_price" name="total_sell_price" readonly>
                                                @error('total_sell_price')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-1-5">
                                            <div class="form-group">
                                                <label for="sn">IMEI/SN</label>
                                                <textarea class="form-control @error('sn') is-invalid @enderror"
                                                          id="sn" name="sn" placeholder="IMEI/SN"></textarea>
                                                @error('sn')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-1-5">
                                            <div class="form-group">
                                                <label for="warranty_id">Warranty</label>
                                                <select id="warranty_id" name="warranty_id"
                                                        class="select2 form-control @error('warranty_id') is-invalid @enderror">
                                                    <option value="none" selected="">Select Warranty</option>
                                                    @foreach($warranties as $warranty)
                                                        <option value="{{ $warranty->id }}"> {{ $warranty->name }} </option>
                                                    @endforeach
                                                </select>
                                                @error('warranty_id')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group" style="margin-top: 26px;">
                                                <button id="action" class="btn btn-primary btn-md" type="button"
                                                        onclick="add()">
                                                    <i class="icon-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table table-responsive">
                                                <table class="table table-bordered table-hover " id="table-data-list">
                                                    <thead>
                                                    <tr>
                                                        <th>SL</th>
                                                        <th>Product Info</th>
                                                        <th>IMEI/SN</th>
                                                        <th>Stock Qty</th>
                                                        <th>Sell Price</th>
                                                        <th>Sell Qty</th>
                                                        <th>Row Total</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                    <tfoot>
                                                    <tr>
                                                        <th colspan="6" class="text-right"><label for="discount">Discount Percentage</label></th>
                                                        <th style="text-align: center;">
                                                            <div class="form-group">
                                                                <input type="text"
                                                                       class="form-control discount_percent @error('discount_percent') is-invalid @enderror"
                                                                       id="discount_percent" name="discount_percent">
                                                                @error('discount_percent')
                                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                            </div>

                                                        </th>
                                                        <th></th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="6" class="text-right"><label for="discount">Discount Amount</label></th>
                                                        <th style="text-align: center;">
                                                                <div class="form-group">
                                                                    <input type="text"
                                                                           class="form-control discount @error('discount') is-invalid @enderror"
                                                                           id="discount" name="discount">
                                                                    @error('discount')
                                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                                </div>

                                                        </th>
                                                        <th></th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="6" class="text-right">Grand Total</th>
                                                        <th style="text-align: center;">
                                                            <div id="grand_total_text"></div>
                                                            <input type="hidden" id="grand_total" name="grand_total">
                                                        </th>
                                                        <th></th>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-actions right">
                                    <button type="button" class="btn btn-warning mr-1">
                                        <i class="ft-refresh-ccw"></i> Reload
                                    </button>
                                    <button type="submit" class="btn btn-primary" name="saveInvoice">
                                        <i class="fa fa-check-square-o"></i> Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')

    <!-- Script -->

    <script type="text/javascript">

        $('#sn').keydown(function(e){
        if (e.keyCode == 13) { // barcode scanned!
            $('#sn').val($('#sn').val() + ',');
            return false;
        }
        });

        var cashArray = [1];
        var bankArray = [2, 3, 4, 5];
        var paymentChequeArray = [3, 4];

        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');


        $().ready(function () {
            $('form#invoice-form').submit(function () {
                // Get the Login Name value and trim it
                var date = $.trim($('#date').val());
                var store_id = $.trim($('#store_id').val());
                var customer_id = $.trim($('#customer_id').val());
                var cash_credit = $.trim($('#cash_credit').val());
                var payment_method = $.trim($('#payment_method').val());
                var bank_id = $.trim($('#bank_id').val());
                var cheque_no = $.trim($('#cheque_no').val());
                var cheque_date = $.trim($('#cheque_date').val());

                if (date === '') {
                    toastr.warning(" Please select  date!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }
                if (store_id === '') {
                    toastr.warning(" Please select  store!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }
                if (customer_id === '') {
                    toastr.warning(" Please select  customer!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }
                if (cash_credit === '') {
                    toastr.warning(" Please select  cash/credit!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }

                if (cash_credit === 1) { //if cash
                    if (payment_method === '') {
                        toastr.warning(" Please select  payment method!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                        return false;
                    }
                    payment_method = nanCheck(payment_method);
                    if (isValidCode(payment_method, bankArray)) {
                        if (bank_id === '') {
                            toastr.warning(" Please select  bank!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                            return false;
                        }
                        if (isValidCode(payment_method, paymentChequeArray)) {
                            if (cheque_no === '' || cheque_date === '') {
                                toastr.warning(" Please select  cheque no & cheque date!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                                return false;
                            }
                        }
                    }
                }

                var rowCount = $('#table-data-list tbody tr.cartList').length;
                if (nanCheck(rowCount) <= 0 || rowCount === 'undefined') {
                    toastr.warning(" Please add atleast one item to grid!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }
            });


            $('form#customer-form').submit(function (e) {
                e.preventDefault();
                // Get the Login Name value and trim it
                var name = $.trim($('#customerName').val());
                var store = $.trim($('#store').val());
                var contract_no = $.trim($('#customerContact').val());
                var address = $.trim($('#address').val());

                /*if (name === '') {
                    toastr.warning(" Please Enter Customer Name!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }*/
                if (store === '') {
                    toastr.warning(" Please select  store!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }
                if (contract_no === '') {
                    toastr.warning(" Please Enter Customer Mobile no!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }
                /*if (address === '') {
                    toastr.warning(" Please Enter Customer Address!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }*/
                ajaxSave();
            });


        });


        function ajaxSave() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('crm.customers.ajaxStore') }}",
                type: 'post',
                dataType: "json",
                cache: false,
                data: $('form#customer-form').serialize(),
                beforeSend: function () {
                    var contact = $.trim($('#customerContact').val());
                    if (contact == "" || contact == null) {
                        toastr.warning(" Please Enter Customer Phone No!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                        return false;
                    }
                },
                success: function (result) {
                    if (result.error === false) {
                        $(".print-success-msg").css('display', 'block');
                        $(".print-success-msg").html(result.message);
                        $('#customer_name').val(result.data.name);
                        $('#customer_code').val(result.data.code);
                        $('#store_id').val(result.data.store_id);
                        $('#customer_id').val(result.data.id);
                        $('#contact_no').val(result.data.contact_no);
                        toastr.success("Customer Created Successfully ", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                        $('#demoModal').modal('hide');
                        flashMessage('success');
                    } else {
                        printErrorMsg(result.data);
                        flashMessage('error');
                    }
                },
                error: function (xhr, textStatus, thrownError) {
                    alert(xhr + "\n" + textStatus + "\n" + thrownError);
                }
            }).done(function (data) {
                console.log("REQUEST DONE;");
            }).fail(function (jqXHR, textStatus) {
                console.log("REQUEST FAILED;");
            });
        }


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
            $(function () {
                $("#cheque_date").datepicker({
                    // appendText:"(yy-mm-dd)",
                    dateFormat: "yy-mm-dd",
                    altField: "#datepicker",
                    altFormat: "DD, d MM, yy",
                    prevText: "click for previous months",
                    nextText: "click for next months",
                    showOtherMonths: true,
                    selectOtherMonths: true,
                });
            });

            // customer name wise search start
            $("#customer_name").autocomplete({
                minLength: 1,
                autoFocus: true,
                source: function (request, response) {
                    var store_id = $("#store_id").val();
                    $.ajax({
                        url: "{{ route('customer.name.autocomplete') }}",
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
                    // console.log('customer_code');
                    var store_id = $("#store_id").val();
                    $.ajax({
                        url: "{{ route('customer.code.autocomplete') }}",
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

            // customer name wise search start
            $("#contact_no").autocomplete({
                minLength: 1,
                autoFocus: true,
                source: function (request, response) {
                    var store_id = $("#store_id").val();
                    $.ajax({
                        url: "{{ route('customer.contact.autocomplete') }}",
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
        });


        $("#product_name").autocomplete({
            minLength: 1,
            autoFocus: true,
            source: function (request, response) {
                var store_id = $("#store_id").val();
                var customer_id = $("#customer_id").val();
                if (store_id > 0 && customer_id > 0) {
                    $.ajax({
                        url: "{{ route('product.name.autocomplete') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term,
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                } else {
                    toastr.error("Please select store & customer!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                }
            },
            focus: function (event, ui) {
                // console.log(event);
                // console.log(ui);
                return false;
            },
            select: function (event, ui) {
                if (ui.item.value != '' || ui.item.value > 0) {
                    getProductPrice(ui.item.value);
                    getProductStock(ui.item.value);
                    $('#product_name').val(ui.item.name);
                    $('#warranty_id').val(ui.item.warranty);
                    $('#product_code').val(ui.item.code);
                    $('#product_id').val(ui.item.value);
                } else {
                    resetProduct();
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


        $("#product_code").autocomplete({
            minLength: 1,
            autoFocus: true,
            source: function (request, response) {
                var store_id = $("#store_id").val();
                var customer_id = $("#customer_id").val();
                if (store_id > 0 && customer_id > 0) {
                    $.ajax({
                        url: "{{ route('product.code.autocomplete') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term,
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                } else {
                    toastr.error("Please select store & customer!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                }
            },
            focus: function (event, ui) {
                return false;
            },
            select: function (event, ui) {
                if (ui.item.value != '' || ui.item.value > 0) {
                    getProductPrice(ui.item.value);
                    getProductStock(ui.item.value);
                    $('#product_name').val(ui.item.name);
                    $('#product_code').val(ui.item.code);
                    $('#warranty_id').val(ui.item.warranty);
                    $('#product_id').val(ui.item.value);
                } else {
                    resetProduct();
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


        $("#cash_credit").change(function () {
            this.value == 1 ? showPaymentOption() : hidePaymentOption();
        });

        $("#store_id").change(function () {
            clearCustomerData();
        });

        $("#payment_method").change(function () {
            var val = nanCheck(parseInt(this.value));
            if (isValidCode(val, cashArray)) {
                $(".bank_other_payment").hide();
            } else if (isValidCode(val, bankArray)) {
                $(".bank_other_payment").show();
            } else {
                $(".bank_other_payment").hide();
            }
        });


        function add() {
            var product_id = nanCheck($("#product_id").val());
            var stock_qty = nanCheck(parseFloat($("#stock_qty").val()));
            var sell_qty = nanCheck(parseFloat($("#qty").val()));
            var sell_price = nanCheck(parseFloat($("#sell_price").val()));
            var warranty_id = nanCheck($("#warranty_id").val());
            var min_sell_price = nanCheck(parseFloat($("#min_sell_price").val()));
            // console.log("SELL PRICE:" + sell_price);
            var message;
            var error = true;
            if (product_id === '' || product_id === 0) {
                message = "Please select a product!";
            } else if (sell_qty <= 0 || sell_qty === '') {
                message = "Please insert sell qty!";
            } else if (stock_qty < sell_qty) {
                message = "Stock qty exceeded!";
            } else if (sell_price <= 0 || sell_price === '') {
                message = "Please insert sell price!";
            } else if (min_sell_price <= 0 || min_sell_price === '') {
                message = "Sell price not found!";
            } else if (sell_price < min_sell_price) {
                $("#sell_price").val(min_sell_price);
                message = "Minimum sell price is: " + sell_price;
            } else {
                var isproductpresent = 'no';
                var temp_codearray = document.getElementsByName("product[temp_product_id][]");
                if (temp_codearray.length > 0) {
                    for (var l = 0; l < temp_codearray.length; l++) {
                        var code = temp_codearray[l].value;
                        if (code == product_id) {
                            isproductpresent = 'yes';
                        }
                    }
                }
                if (isproductpresent === 'no') {
                    addNewRow();
                    calculateGrandTotal();
                    resetProduct();
                    error = false;
                    message = "Product added to grid.";
                } else {
                    message = "Product is already added to grid! Please try with another product!";
                }
            }
            if (error === true) {
                toastr.error(message, 'Message <i class="fa fa-bell faa-ring animated"></i>');
            }

        }

        function addNewRow() {
            var product_id = nanCheck(parseFloat($("#product_id").val()));
            var product_name = $("#product_name").val();
            var product_code = $("#product_code").val();
            var stock_qty = nanCheck(parseFloat($("#stock_qty").val()));
            var sell_qty = nanCheck(parseFloat($("#qty").val()));
            var warranty_id = nanCheck($("#warranty_id").val());
            var sn = $("#sn").val();
            var warrantyText = $("#warranty_id option:selected").text();
            var sell_price = nanCheck(parseFloat($("#sell_price").val()));
            var min_sell_price = nanCheck(parseFloat($("#min_sell_price").val()));
            var total_sell_price = nanCheck(parseFloat($("#total_sell_price").val()));

            // console.log("SELL---QTY:" + sell_qty);
            var slNumber = $('#table-data-list tbody tr.cartList').length + 1;
            var appendTxt = "<tr class='cartList'>"
            appendTxt += "<td class='count' style='text-align: center;'>" + slNumber + "</td>";
            appendTxt += "<td style='text-align: left;'>Name: " + product_name + "<br><small class='cart-product-code'>Code: " + product_code + "</small><br><small class='cart-product-warranty'>Warranty: " + warrantyText + "</small><input type='hidden' class='temp_product_id' name='product[temp_product_id][]' value='" + product_id + "'></td>";
            appendTxt += "<td style='text-align: center;'>"+sn+"<input type='hidden' class='form-control temp_sn' readonly name='product[temp_sn][]' value='" + sn + "'></td>";
            appendTxt += "<td style='text-align: center;'><input type='text' class='form-control temp_stock_qty' readonly name='product[temp_stock_qty][]' onkeyup='calculateRowTotalOnChange();' value='" + stock_qty + "'></td>";
            appendTxt += "<td style='text-align: center;'><input type='text' class='form-control temp_sell_price ' readonly name='product[temp_sell_price][]' onkeyup='calculateRowTotalOnChange();' value='" + sell_price + "'><input type='hidden' name='product[temp_min_sell_price][]' class='temp_min_sell_price' value='" + min_sell_price + "'></td>";
            appendTxt += "<td style='text-align: center;'><input type='text' class='form-control temp_sell_qty' name='product[temp_sell_qty][]' onkeyup='calculateRowTotalOnChange();' value='" + sell_qty + "'></td>";
            appendTxt += "<td style='text-align: center;'><input type='text' class='form-control temp_row_sell_price' name='product[temp_row_sell_price][]' readonly value='" + total_sell_price + "'><input type='hidden' class='form-control temp_warranty' name='product[temp_warranty][]' readonly value='" + warranty_id + "'></td>";
            appendTxt += "<td style='text-align: center;'><button title=\"remove\"  type=\"button\" class=\"rdelete dltBtn btn btn-danger btn-md\" onclick=\"deleteRows($(this))\"><i class=\"icon-trash\"></i></button></td>";
            appendTxt += "</tr>";

            var tbodyRow = $('#table-data-list tbody tr.cartList').length;
            if (tbodyRow >= 1)
                $("#table-data-list tbody tr:last").after(appendTxt);
            else
                $("#table-data-list tbody").append(appendTxt);

        }

        $(document).on('input keyup drop paste', ".temp_sell_price, .temp_sell_qty", function (e) {
            calculateRowTotalOnChange();
        });

        $(document).on('input keyup drop paste', ".discount", function (e) {
            calculateGrandTotal();
        });

        $(document).on('input keyup drop paste', ".discount_percent", function (e) {
            calculateDiscountAmount();
        });

        function deleteRows(element) {
            var result = confirm("Are you sure you want to Delete?");
            if (result) {
                var temp_item_id = element.parents('tr').find('.cart-product-code').html();
                console.log('deleting item ...' + temp_item_id);

                $(element).parents("tr").remove();
                toastr.success(temp_item_id + " removed from grid.", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                var itemCounter = 0;
                $("#table-data-list tbody tr td.sno").each(function (index, element) {
                    itemCounter++;
                    $(element).text(index + 1);
                });

                calculateGrandTotal();

                console.log(temp_item_id + " Deleted Successfully!");
            }
        }


        function getProductPrice(product_id) {
            $.ajax({
                url: "{{ route('product.price') }}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    search: product_id,
                },
                success: function (data) {
                    $("#sell_price").val(data.sell_price);
                    $("#min_sell_price").val(data.min_whole_sell_price);
                },
                error: function (xhr, status, error) {
                    $("#sell_price").val(0);
                    $("#min_sell_price").val(0);
                }
            }).done(function (data) {
                $("#sell_price").val(data.sell_price);
                $("#min_sell_price").val(data.min_whole_sell_price);
            }).fail(function (jqXHR, textStatus) {
                $("#sell_price").val(0);
                $("#min_sell_price").val(0);
            });
        }

        function getProductStock(product_id) {
            var store_id = $("#store_id").val();
            $.ajax({
                url: "{{ route('product.stockQty') }}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    search: product_id,
                    store_id: store_id,
                },
                success: function (data) {
                    $("#stock_qty").val(data.closing_balance);
                },
                error: function (xhr, status, error) {
                    $("#stock_qty").val(0);
                }
            }).done(function (data) {
                $("#stock_qty").val(data.closing_balance);
            }).fail(function (jqXHR, textStatus) {
                $("#stock_qty").val(0);
            });
        }

        function showPaymentOption() {
            $('.cash_payment').show();
        }

        function resetCustomer() {
            $('#customer_name').val("");
            $('#customer_code').val("");
            $('#customer_id').val("");
            $('#contact_no').val("");
        }

        function resetProduct() {
            $('#product_code').val("");
            $('#product_id').val("");
            $('#product_name').val("");
            $('#qty').val("");
            $('#stock_qty').val("");
            $('#sell_price').val("");
            $('#min_sell_price').val("");
            $('#total_sell_price').val("");
            $("#warranty_id").val("none");
            $("#sn").val("");
        }

        function clearCustomerData() {
            $('#customer_name').val("");
            $('#customer_id').val("");
            $('#customer_code').val("");
            $('#contact_no').val("");
        }

        function hidePaymentOption() {
            $('.cash_payment').hide();
            $('#payment_method').val("");
            $('#bank_id').val("");
            $('#cheque_no').val("");
            $('#cheque_date').val("");
        }

        function calculateTotal() {
            var qty = nanCheck(parseFloat($("#qty").val()));
            var sell_price = nanCheck(parseFloat($("#sell_price").val()));
            var min_sell_price = nanCheck(parseFloat($("#min_sell_price").val()));
            if (sell_price < min_sell_price) {
                toastr.error("Minimum sell price for this product is: " + min_sell_price, 'Message <i class="fa fa-bell faa-ring animated"></i>');
                // $("#sell_price").val(min_sell_price);
                $("#total_sell_price").val(qty * sell_price);
            } else {
                $("#total_sell_price").val(qty * sell_price);
            }
        }

        function nanCheck(value) {
            return isNaN(value) ? 0 : value;
        }

        function isValidCode(code, codes) {
            return ($.inArray(code, codes) > -1);
        }

        function calculateGrandTotal() {
            var grand_total = 0;
            var discount = nanCheck(parseFloat($("#discount").val()));
            $('#table-data-list .temp_row_sell_price').each(function () {
                grand_total += nanCheck(parseFloat(this.value));
            });
            $("#grand_total_text").html(grand_total-discount);
            $("#grand_total").val(grand_total-discount);
        }

        function calculateDiscountAmount() {
            var grand_total = 0;
            var discount = 0;
            var discount_percent = nanCheck(parseFloat($("#discount_percent").val()));
            $('#table-data-list .temp_row_sell_price').each(function () {
                grand_total += nanCheck(parseFloat(this.value));
            });

            discount = (grand_total * discount_percent) / 100;

            $("#discount").val(discount);
            $("#grand_total_text").html(grand_total-discount);
            $("#grand_total").val(grand_total-discount);
        }

        function calculateRowTotalOnChange() {
            var serial = 0;
            var grandTotal = 0;
            $("#table-data-list tbody tr.cartList td.count").each(function (index, element) {

                    console.log("CALCULATION STARTED::" + index);
                    serial++;
                    var temp_stock_qty = nanCheck(parseFloat($(this).closest('tr').find(".temp_stock_qty").val()));
                    var temp_sell_price = nanCheck(parseFloat($(this).closest('tr').find(".temp_sell_price").val()));
                    var temp_min_sell_price = nanCheck(parseFloat($(this).closest('tr').find(".temp_min_sell_price").val()));
                    var temp_sell_qty = nanCheck(parseFloat($(this).closest('tr').find(".temp_sell_qty").val()));
                    var temp_row_sell_price = nanCheck(parseFloat($(this).closest('tr').find(".temp_row_sell_price").val()));

                    if (temp_sell_price < temp_min_sell_price) {
                        temp_sell_price = temp_min_sell_price;
                        $(this).closest('tr').find(".temp_sell_price ").val(temp_min_sell_price);
                        toastr.warning("Minimum sell price is: " + temp_min_sell_price, 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    }
                    // console.log("MIN: " + temp_min_sell_price + ", SP: " + temp_sell_price);
                    if (temp_sell_qty <= 0) {
                        temp_sell_qty = 1;
                        $(this).closest('tr').find(".temp_sell_qty ").val(temp_sell_qty);
                        toastr.warning("Minimum sell qty is: " + temp_sell_qty, 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    }

                    if (temp_sell_qty > temp_stock_qty) {
                        temp_sell_qty = temp_stock_qty;
                        $(this).closest('tr').find(".temp_sell_qty ").val(temp_sell_qty);
                        toastr.warning("Sell qty exceeded!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    }
                    var row_total = temp_sell_qty * temp_sell_price;

                    $(this).closest('tr').find(".temp_row_sell_price").val(row_total.toFixed(2));
                }
            );
            calculateGrandTotal();
            calculateDiscountAmount();
        }

        // Restricts input for the set of matched elements to the given inputFilter function.
        $(document).on('input keyup  drop paste', "#qty, #sell_price, .temp_sell_price, .temp_sell_qty", function (evt) {
            var self = $(this);
            self.val(self.val().replace(/[^0-9\.]/g, ''));
            if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) {
                evt.preventDefault();
            }
        });
        $(document).ready(function(){
            $( document ).on( 'focus', ':input', function(){
                $( this ).attr( 'autocomplete', 'off' );
            });
        });


        function printErrorMsg(msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display', 'block');
            $.each(msg, function (key, value) {
                $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
            });
        }

        function flashMessage(value = 'success') {
            if (value === 'success') {
                $(".print-success-msg-msg").fadeTo(2000, 500).slideUp(500, function () {
                    $(".print-success-msg").slideUp(500);
                });
            } else {
                $(".print-error-msg").fadeTo(2000, 500).slideUp(500, function () {
                    $(".print-error-msg").slideUp(500);
                });
            }
        }
    </script>

@endpush
