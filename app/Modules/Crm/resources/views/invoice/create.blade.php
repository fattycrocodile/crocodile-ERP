@extends('layouts.app')
@section('title') {{ isset($pageTitle) ? $pageTitle : 'Create Invoice' }} @endsection

@push('styles')
    <!-- CSS -->
    <style>
        .ui-datepicker {
            z-index: 999 !important;
        }

        .credit_payment {
            display: none;
        }
    </style>
@endpush
@section('content')

    @include('inc.flash')

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
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <div class="card-text">
                            </div>
                            <form class="form" id="invoice-form">
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
                                                        <option value="{{ $key }}"> {{ $store }} </option>
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
                                                <input type="text" class="form-control" id="contact_no" readonly
                                                       disabled
                                                       value="">
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

                                        <div class="col-md-2 credit_payment">
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

                                        <div class="col-md-2 credit_payment">
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

                                        <div class="col-md-2 credit_payment">
                                            <div class="form-group">
                                                <label for="cheque_no">Cheque/Transaction No</label>
                                                <input type="text"
                                                       class="form-control @error('cheque_no') is-invalid @enderror"
                                                       id="cheque_no">
                                                @error('cheque_no')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2 credit_payment">
                                            <div class="form-group">
                                                <label for="cheque_date">Cheque Date</label>
                                                <input type="text"
                                                       class="form-control @error('cheque_date') is-invalid @enderror"
                                                       id="cheque_date">
                                                @error('cheque_date')
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
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="product_code">Product Code</label>
                                                <input type="text"
                                                       class="form-control @error('product_id') is-invalid @enderror"
                                                       id="product_code" name="product_code">
                                                @error('product_id')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="qty">Qty</label>
                                                <input type="text"
                                                       class="form-control @error('qty') is-invalid @enderror"
                                                       id="qty" name="qty" onkeyup="calculateTotal();">
                                                @error('qty')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
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
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="total_sell_price">Total Sell Price</label>
                                                <input type="text"
                                                       class="form-control @error('total_sell_price') is-invalid @enderror"
                                                       id="total_sell_price" name="total_sell_price" readonly>
                                                @error('total_sell_price')
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
                                                        <th colspan="5">Grand Total</th>
                                                        <th style="text-align: center;">
                                                            <div id="grand_total_text"></div>
                                                            <input type="hidden" id="grand_total">
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
                    // maxDate: new Date()
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


        $("#product_name").autocomplete({
            minLength: 1,
            autoFocus: true,
            source: function (request, response) {
                var store_id = $("#store_id").val();
                var customer_id = $("#customer_id").val();
                if (store_id > 0 && customer_id > 0) {
                    $.ajax({
                        url: "{{ route('productNameAutoComplete') }}",
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
                        url: "{{ route('productCodeAutoComplete') }}",
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


        $("#cash_credit").change(function () {
            this.value == 1 ? showPaymentOption() : hidePaymentOption();
        });

        $("#store_id").change(function () {
            clearCustomerData();
        });

        $('.temp_sell_price, .temp_sell_qty').keyup(function (event) {
            console.log(event);
            calculateRowTotalOnChange();
        });


        function add() {
            var product_id = $("#product_id").val();
            var stock_qty = parseFloat($("#stock_qty").val());
            var sell_qty = parseFloat($("#qty").val());
            var sell_price = parseFloat($("#sell_price").val());
            var minimum_sell_price = parseFloat($("#minimum_sell_price").val());
            console.log("SELL PRICE:" + sell_price);
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
            } else if (minimum_sell_price <= 0 || minimum_sell_price === '') {
                message = "Sell price not found!";
            } else if (sell_price < minimum_sell_price) {
                $("#sell_price").val(minimum_sell_price);
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

        function addNewRow(dataArray) {
            var product_id = $("#product_id").val();
            var product_name = $("#product_name").val();
            var product_code = $("#product_code").val();
            var stock_qty = parseFloat($("#stock_qty").val());
            var sell_qty = parseFloat($("#qty").val());
            var sell_price = parseFloat($("#sell_price").val());
            var minimum_sell_price = parseFloat($("#minimum_sell_price").val());
            var total_sell_price = parseFloat($("#total_sell_price").val());

            // console.log("SELL---QTY:" + sell_qty);
            var slNumber = $('#table-data-list tbody tr.cartList').length + 1;
            var appendTxt = "<tr class='cartList'>"
            appendTxt += "<td class='count' style='text-align: center;'>" + slNumber + "</td>";
            appendTxt += "<td style='text-align: left;'>Name: " + product_name + "<br><small class='cart-product-code'>Code: " + product_code + "</small><input type='hidden' class='temp_product_id' name='product[temp_product_id][]' value='" + product_id + "'></td>";
            appendTxt += "<td style='text-align: center;'><input type='text' class='form-control temp_stock_qty' readonly name='product[temp_stock_qty][]' onkeyup='calculateRowTotalOnChange();' value='" + stock_qty + "'></td>";
            appendTxt += "<td style='text-align: center;'><input type='text' class='form-control temp_sell_price ' name='product[temp_sell_price][]' onkeyup='calculateRowTotalOnChange();' value='" + sell_price + "'><input type='hidden' name='product[temp_minimum_sell_price][]' class='temp_minimum_sell_price' value='" + minimum_sell_price + "'></td>";
            appendTxt += "<td style='text-align: center;'><input type='text' class='form-control temp_sell_qty' name='product[temp_sell_qty][]' onkeyup='calculateRowTotalOnChange();' value='" + sell_qty + "'></td>";
            appendTxt += "<td style='text-align: center;'><input type='text' class='form-control temp_row_sell_price' name='product[temp_row_sell_price][]' readonly value='" + total_sell_price + "'></td>";
            appendTxt += "<td style='text-align: center;'><button title=\"remove\"  type=\"button\" class=\"rdelete dltBtn btn btn-danger btn-md\" onclick=\"deleteRows($(this))\"><i class=\"icon-trash\"></i></button></td>";
            appendTxt += "</tr>";

            var tbodyRow = $('#table-data-list tbody tr.cartList').length;
            if (tbodyRow >= 1)
                $("#table-data-list tbody tr:last").after(appendTxt);
            else
                $("#table-data-list tbody").append(appendTxt);

        }

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


        $().ready(function () {
            $('form#invoice-form').submit(function () {
                // Get the Login Name value and trim it
                var name = $.trim($('#log').val());

                // Check if empty of not
                if (name === '') {
                    alert('Text-field is empty.');
                    return false;
                }
            });
        });


        function getProductPrice(product_id) {
            $.ajax({
                url: "{{ route('productPrice') }}",
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
                url: "{{ route('productStockQty') }}",
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
            $('.credit_payment').show();
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
        }

        function clearCustomerData() {
            $('#customer_name').val("");
            $('#customer_id').val("");
            $('#customer_code').val("");
            $('#contact_no').val("");
        }

        function hidePaymentOption() {
            $('.credit_payment').hide();
            $('#payment_method').val("");
            $('#bank_id').val("");
            $('#cheque_no').val("");
            $('#cheque_date').val("");
        }

        function calculateTotal() {
            var qty = parseFloat($("#qty").val());
            var sell_price = parseFloat($("#sell_price").val());
            var min_sell_price = parseFloat($("#min_sell_price").val());
            //console.log("QTY=" + qty + ", SELL PRICE= " + sell_price + ", MIN SELL PRICE= "+ min_sell_price)
            if (sell_price < min_sell_price) {
                toastr.error("Minimum sell price for this product is: " + min_sell_price, 'Message <i class="fa fa-bell faa-ring animated"></i>');
                $("#sell_price").val(min_sell_price);
                $("#total_sell_price").val(qty * min_sell_price);
            } else {
                $("#total_sell_price").val(qty * min_sell_price);
            }
        }


        function calculateGrandTotal() {
            var grand_total = 0;
            $('#table-data-list .temp_row_sell_price').each(function () {
                grand_total += parseFloat(this.value);
            });
            $("#grand_total_text").html(grand_total);
            $("#grand_total").val(grand_total);
        }

        function calculateRowTotalOnChange() {
            var serial = 0;
            var grandTotal = 0;
            $("#table-data-list tbody tr.cartList td.temp_product_id").each(function (index, element) {
                    serial++;
                    var temp_stock_qty = parseFloat($(this).closest('tr').find(".temp_stock_qty ").val());
                    var temp_sell_price = parseFloat($(this).closest('tr').find(".temp_sell_price ").val());
                    var temp_minimum_sell_price = parseFloat($(this).closest('tr').find(".temp_minimum_sell_price ").val());
                    var temp_sell_qty = parseFloat($(this).closest('tr').find(".temp_sell_qty ").val());
                    var temp_row_sell_price = parseFloat($(this).closest('tr').find(".temp_row_sell_price ").val());

                    if (temp_sell_price < temp_minimum_sell_price) {
                        temp_sell_price = temp_minimum_sell_price;
                        $(this).closest('tr').find(".temp_sell_price ").val(temp_minimum_sell_price);
                        toastr.warn("Minimum sell price is: " + temp_minimum_sell_price, 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    }
                    if (temp_sell_qty <= 0) {
                        temp_sell_qty = 1;
                        $(this).closest('tr').find(".temp_sell_qty ").val(temp_sell_qty);
                        toastr.warn("Minimum sell qty is: " + temp_sell_qty, 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    }

                    if (temp_sell_qty > temp_stock_qty) {
                        temp_sell_qty = temp_stock_qty;
                        $(this).closest('tr').find(".temp_sell_qty ").val(temp_sell_qty);
                        toastr.warn("Sell qty exceeded!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    }
                    var row_total = temp_sell_qty * temp_sell_price;

                    $(this).closest('tr').find(".temp_row_sell_price").val(row_total.toFixed(2));
                }
            );
            calculateGrandTotal();
        }


        // Restricts input for the set of matched elements to the given inputFilter function.
        (function ($) {
            $.fn.inputFilter = function (inputFilter) {
                return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function () {
                    if (inputFilter(this.value)) {
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    } else {
                        this.value = "";
                    }
                });
            };
        }(jQuery));

        $(document).ready(function () {
            $("#qty, #sell_price, .temp_sell_price, .temp_sell_qty").inputFilter(function (value) {
                return /^\d*$/.test(value);    // Allow digits only, using a RegExp
            });
        });

    </script>

@endpush
