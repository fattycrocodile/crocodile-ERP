@extends('layouts.app')
@section('title') {{ isset($pageTitle) ? $pageTitle : 'Create Store transfer' }} @endsection

@push('styles')
    <!-- CSS -->
    <style>
        .ui-datepicker {
            z-index: 999 !important;
        }

        .bank_other_payment, .cash_payment_bank {
            display: none;
        }
    </style>
@endpush
@section('content')

    <div class="alert alert-danger print-error-msg " style="display:none">
        <ul></ul>
    </div>

    <div class="alert alert-success print-success-msg" style="display:none">
    </div>
    <section id="basic-form-layouts">
        <div class="row match-height">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-form">Store Info</h4>
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
                            <form class="form" id="mr-form" action="{{route('storeInventory.st.store')}}" method="post"
                                  autocomplete="off">
                                @csrf

                                <div class="form-body">
                                    <h4 class="form-section"><i class="ft-user"></i> Store Info</h4>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="date">Date</label>
                                                <input type="text"
                                                       class="form-control @error('date') is-invalid @enderror"
                                                       id="date" value="{!! date('Y-m-d') !!}" name="date" required>
                                                @error('date')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="send_store_id">Send Store</label>
                                                <select id="send_store_id" name="send_store_id" required
                                                        class="select2 form-control @error('send_store_id') is-invalid @enderror">
                                                    <option value="none" selected="">Select Store</option>
                                                    @foreach($stores as $key => $store)
                                                        <option value="{{ $store->id }}"> {{ $store->name }} </option>
                                                    @endforeach
                                                </select>
                                                @error('send_store_id')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="rcv_store_id">Receive Store</label>
                                                <select id="rcv_store_id" name="rcv_store_id" required
                                                        class="select2 form-control @error('rcv_store_id') is-invalid @enderror">
                                                    <option value="none" selected="">Select Store</option>
                                                    @foreach($stores2 as $key => $store)
                                                        <option value="{{ $store->id }}"> {{ $store->name }} </option>
                                                    @endforeach
                                                </select>
                                                @error('rcv_store_id')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="remarks">remarks</label>
                                                <textarea class="form-control" id="remarks" name="remarks">
                                                </textarea>
                                            </div>
                                        </div>

                                    </div>

                                    <h4 class="form-section"><i class="fa fa-paperclip"></i> Product Information</h4>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="product_name">Product Name</label>
                                                <input type="text"
                                                       class="form-control @error('product_name') is-invalid @enderror"
                                                       id="product_name" name="product_name">
                                                <input type="hidden" name="product_id" id="product_id">
                                                @error('product_id')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="product_code">Product Code</label>
                                                <input type="text"
                                                       class="form-control @error('product_id') is-invalid @enderror"
                                                       id="product_code" name="product_code">
                                                @error('product_id')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="qty">Transfer Qty</label>
                                                <input type="text"
                                                       class="form-control @error('qty') is-invalid @enderror"
                                                       id="qty" name="qty">
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
                                                        <th>Transfer Qty</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                    <tfoot>
                                                    <tr>
                                                        <th colspan="3" class="text-right">Grand Total</th>
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

                                    <div class="spinner-div text-center" style="display: none;">
                                        <button type="button" class="btn btn-lg btn-success mb-1">
                                            <i class="fa fa-spinner fa-pulse fa-fw"></i> Please wait..
                                        </button>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-actions right">
                                            <button type="button" class="btn btn-warning mr-1">
                                                <i class="ft-refresh-ccw"></i> Reload
                                            </button>
                                            <button type="submit" class="btn btn-primary" name="saveInvoice"
                                                    id="saveInvoice">
                                                <i class="fa fa-check-square-o"></i> Save
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade text-left" id="xlarge" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel16"
                         aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel16">Voucher</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="button" class="btn btn-outline-primary">Print</button>
                                </div>
                            </div>
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

        var cashArray = [1];
        var bankArray = [2, 3, 4, 5];
        var paymentChequeArray = [3, 4];

        var due = new Array();

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

        function nanCheck(value) {
            return isNaN(value) ? 0 : value;
        }

        function isValidCode(code, codes) {
            return ($.inArray(code, codes) > -1);
        }

        function hidePaymentOption() {
            $('.cash_payment').hide();
            $('#payment_method').val("");
            $('#bank_id').val("");
            $('#cheque_no').val("");
            $('#cheque_date').val("");
        }


        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $("#product_name").autocomplete({
            minLength: 1,
            autoFocus: true,
            source: function (request, response) {
                var store_id = $("#send_store_id").val();
                if (store_id > 0) {
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
                    toastr.error("Please select send store ", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                }
            },
            focus: function (event, ui) {
                return false;
            },
            select: function (event, ui) {
                if (ui.item.value != '' || ui.item.value > 0) {
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
                var store_id = $("#send_store_id").val();
                if (store_id > 0) {
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
                    toastr.error("Please select send store !", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                }
            },
            focus: function (event, ui) {
                return false;
            },
            select: function (event, ui) {
                if (ui.item.value != '' || ui.item.value > 0) {
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

            var inner_html = '<div>' + item.label + ' (<i>' + item.name + ')</i></div>';
            return $("<li>")
                .data("item.autocomplete", item)
                .append(inner_html)
                .appendTo(ul);
        };


        $(document).ready(function () {
            $(document).on('focus', ':input', function () {
                $(this).attr('autocomplete', 'off');
            });
        });

        $("#send_store_id").on('change', function(){
            resetProduct();
        });

        function add() {
            var send_store_id = nanCheck($("#send_store_id").val());
            var rcv_store_id = nanCheck($("#rcv_store_id").val());
            var product_id = nanCheck($("#product_id").val());
            var stock_qty = nanCheck(parseFloat($("#stock_qty").val()));
            var transfer_qty = nanCheck(parseFloat($("#qty").val()));
            var message;
            var error = true;
            if (product_id === '' || product_id === 0) {
                message = "Please select a product!";
            } else if (transfer_qty > stock_qty) {
                message = "Transfer Quantity Exceeded stock Quantity !";
            } else if (send_store_id == rcv_store_id) {
                message = "Send Store and Receive Store should not be same !";
            } else if (transfer_qty <= 0 || transfer_qty === '') {
                message = "Please insert Transfer qty!";
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
            var transfer_qty = nanCheck(parseFloat($("#qty").val()));

            // console.log("SELL---QTY:" + purchase_qty);
            var slNumber = $('#table-data-list tbody tr.cartList').length + 1;
            var appendTxt = "<tr class='cartList'>"
            appendTxt += "<td class='count' style='text-align: center;'>" + slNumber + "</td>";
            appendTxt += "<td style='text-align: left;'>Name: " + product_name + "<br><small class='cart-product-code'>Code: " + product_code + "</small><input type='hidden' class='temp_product_id' name='product[temp_product_id][]' value='" + product_id + "'></td>";
            appendTxt += "<td style='text-align: center;'><input type='text' class='form-control temp_stock_qty' readonly name='product[temp_stock_qty][]' onkeyup='calculateRowTotalOnChange();' value='" + stock_qty + "'></td>";
            appendTxt += "<td style='text-align: center;'><input type='text' class='form-control temp_transfer_qty' name='product[temp_transfer_qty][]' onkeyup='calculateRowTotalOnChange();' value='" + transfer_qty + "'></td>";
            appendTxt += "<td style='text-align: center;'><button title=\"remove\"  type=\"button\" class=\"rdelete dltBtn btn btn-danger btn-md\" onclick=\"deleteRows($(this))\"><i class=\"icon-trash\"></i></button></td>";
            appendTxt += "</tr>";

            var tbodyRow = $('#table-data-list tbody tr.cartList').length;
            if (tbodyRow >= 1)
                $("#table-data-list tbody tr:last").after(appendTxt);
            else
                $("#table-data-list tbody").append(appendTxt);

        }

        $(document).on('input keyup drop paste', ".temp_purchase_price, .temp_purchase_qty", function (e) {
            calculateRowTotalOnChange();
        });

        function calculateGrandTotal() {
            var grand_total = 0;
            $('#table-data-list .temp_transfer_qty').each(function () {
                grand_total += nanCheck(parseFloat(this.value));
            });
            $("#grand_total_text").html(grand_total);
            $("#grand_total").val(grand_total);
        }

        function calculateRowTotalOnChange() {
            var serial = 0;
            var grandTotal = 0;
            $("#table-data-list tbody tr.cartList td.count").each(function (index, element) {

                    console.log("CALCULATION STARTED::" + index);
                    serial++;
                    var temp_stock_qty = nanCheck(parseFloat($(this).closest('tr').find(".temp_stock_qty").val()));
                    var temp_transfer_qty = nanCheck(parseFloat($(this).closest('tr').find(".temp_transfer_qty").val()));

                    // console.log("MIN: " + temp_min_sell_price + ", SP: " + temp_sell_price);
                    if (temp_transfer_qty <= 0) {
                        temp_transfer_qty = 1;
                        $(this).closest('tr').find(".temp_transfer_qty ").val(temp_transfer_qty);
                    }

                    if (temp_transfer_qty <= 0) {
                        temp_transfer_qty = 1;
                        $(this).closest('tr').find(".temp_transfer_qty ").val(temp_transfer_qty);
                        toastr.warning("Transfer qty exceeded 0!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    }
                    var row_total = temp_transfer_qty;

                    $(this).closest('tr').find(".temp_row_return_price").val(row_total.toFixed(2));
                }
            );
            calculateGrandTotal();
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
                    $("#return_price").val(data.min_whole_sell_price);
                },
                error: function (xhr, status, error) {
                    $("#return_price").val(0);
                }
            }).done(function (data) {
                $("#return_price").val(data.min_whole_sell_price);
            }).fail(function (jqXHR, textStatus) {
                $("#return_price").val(0);
            });
        }

        function getProductStock(product_id) {
            var store_id = $("#send_store_id").val();
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


        $().ready(function () {
            $('form#mr-form').submit(function (e) {
                e.preventDefault();
                // Get the Login Name value and trim it
                var date = $.trim($('#date').val());
                var send_store_id = $.trim($("#send_store_id").val());
                var rcv_store_id = $.trim($("#rcv_store_id").val());
                var grand_total = nanCheck(parseFloat($.trim($('#grand_total').val())));

                if (date === '') {
                    toastr.warning(" Please select  date!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }
                if (send_store_id === '') {
                    toastr.warning(" Please select Send store!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }
                if (rcv_store_id === '') {
                    toastr.warning(" Please select Receive store!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }


                var rowCount = $('#table-data-list tbody tr.cartList').length;
                if (nanCheck(rowCount) <= 0 || rowCount === 'undefined') {
                    toastr.warning(" Please add at least one item to grid!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }
                // console.log(grand_total);
                if (grand_total <= 0 || grand_total === "") {
                    toastr.warning(" Please insert Transfer Quantity!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                } else {
                    ajaxSave();
                }
            });
        });

        function ajaxSave() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('storeInventory.st.store') }}",
                type: 'post',
                dataType: "json",
                cache: false,
                data: $('form').serialize(),
                beforeSend: function () {
                    if (send_store_id == "" || send_store_id == 0 || send_store_id == null) {
                        toastr.warning(" Please select Send Store!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                        return false;
                    }
                    $('#invoice-infos').html("");
                    $(".spinner-div").show();
                },
                success: function (result) {
                    if (result.error === false) {
                        $(".print-success-msg").css('display', 'block');
                        $(".print-success-msg").html(result.message);
                        $('.modal-body').html(result.data);
                        $('#xlarge').modal('show');

                        $('#send_store_id').html("");
                        $('#rcv_store_id').html("");

                        flashMessage('success');
                    } else {
                        printErrorMsg(result.data);
                        flashMessage('error');
                    }
                    $(".spinner-div").hide();
                    $("#table-data-list tbody").empty();
                },
                error: function (xhr, textStatus, thrownError) {
                    alert(xhr + "\n" + textStatus + "\n" + thrownError);
                    $(".spinner-div").hide();
                    $(".invoice-infos").html("");
                }
            }).done(function (data) {
                console.log("REQUEST DONE;");
            }).fail(function (jqXHR, textStatus) {
                console.log("REQUEST FAILED;");
                $(".spinner-div").hide();
                $(".invoice-infos").html("");
            });
        }

        function printErrorMsg(msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display', 'block');
            $.each(msg, function (key, value) {
                $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
            });
        }

        function resetProduct() {
            $('#product_code').val("");
            $('#product_id').val("");
            $('#product_name').val("");
            $('#qty').val("");
            $('#stock_qty').val("");
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
