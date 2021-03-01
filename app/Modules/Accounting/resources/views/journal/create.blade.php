@extends('layouts.app')
@section('title') {{ isset($pageTitle) ? $pageTitle : 'Create Invoice' }} @endsection

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
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/selects/select2.min.css')}}">
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
                        <h4 class="card-title" id="basic-layout-form">Journal Create</h4>
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
                            <form class="form" id="mr-form" action="{{route('accounting.journal.store')}}" method="post"
                                  autocomplete="off">
                                @csrf

                                <div class="form-body">
                                    <h4 class="form-section"><i class="ft-user"></i> Journal Info</h4>
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
                                                <label for="payto">Journal For</label>
                                                <input type="text"
                                                       class="form-control @error('payto') is-invalid @enderror"
                                                       id="payto" required>
                                                @error('payto')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="type">Type Of Accounts <span class="required text-danger">*</span></label>
                                                <select id="type" name="type" class="select2 form-control  @error('type') is-invalid @enderror">
                                                    <option value="none" selected="" disabled="">Select Type</option>
                                                    <option value="1">Debit</option>
                                                    <option value="2">Credit</option>
                                                </select>
                                                @error('type')<div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="form-section"><i class="fa fa-paperclip"></i> CA Information</h4>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="ca_id">Chart Of Accounts <span class="required text-danger">*</span></label>
                                                <select id="ca_id" name="ca_id" class="select2 form-control  @error('ca_id') is-invalid @enderror">
                                                    <option value="none" selected="" disabled="">Select CA Head
                                                    </option>
                                                    @foreach($ca as $chartofac)
                                                        <option value="{{$chartofac->id}}" {{ old('ca_id')==$chartofac->id?'selected':''}}>{{$chartofac->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('ca_id')<div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="amount">Amount</label>
                                                <input type="text"
                                                       class="form-control @error('amount') is-invalid @enderror"
                                                       id="amount" name="amount">
                                                @error('amount')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="qty">Remarks</label>
                                                <input type="text"
                                                       class="form-control @error('remarks') is-invalid @enderror"
                                                       id="remarks" name="remarks">
                                                @error('remarks')
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
                                                        <th>Chart Of Accounts</th>
                                                        <th>Remarks</th>
                                                        <th>Amount</th>
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



        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        // customer name wise search start

        $(document).ready(function () {
            $(document).on('focus', ':input', function () {
                $(this).attr('autocomplete', 'off');
            });
        });


        function add() {
            var payto = nanCheck($("#payto").val());
            var type = nanCheck(parseFloat($("#type").val()));
            var ca_id = nanCheck(parseFloat($("#ca_id").val()));
            var ca_name = $("#ca_id option:selected").text();
            var amount = nanCheck(parseFloat($("#amount").val()));
            // console.log("SELL PRICE:" + sell_price);
            var message;
            var error = true;
            if (amount === '' || amount === 0) {
                message = "Please Enter Amount!";
            } else if (ca_id <= 0 || ca_id === '') {
                message = "Please Select Chart of Accounts!";
            } else if (type <= 0 || type === '') {
                message = "Please Select Journal Type!";
            }
            else {
                var isproductpresent = 'no';
                var temp_codearray = document.getElementsByName("journal[ca_id][]");
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
                    message = "Journal added to grid.";
                } else {
                    message = "Journal is already added to grid! Please try with another product!";
                }
            }
            if (error === true) {
                toastr.error(message, 'Message <i class="fa fa-bell faa-ring animated"></i>');
            }

        }

        function addNewRow() {
            var ca_id = nanCheck(parseFloat($("#ca_id").val()));
            var ca_name = $("#ca_id option:selected").text();
            var amount = nanCheck(parseFloat($("#amount").val()));
            var remarks = $("#remarks").val();

            // console.log("SELL---QTY:" + purchase_qty);
            var slNumber = $('#table-data-list tbody tr.cartList').length + 1;
            var appendTxt = "<tr class='cartList'>"
            appendTxt += "<td class='count' style='text-align: center;'>" + slNumber + "</td>";
            appendTxt += "<td style='text-align: left;' class='temp_ca'>CA: " + ca_name + "<input type='hidden' class='temp_ca_id' name='journal[temp_ca_id][]' value='" + ca_id + "'></td>";
            appendTxt += "<td style='text-align: center;'><input type='text' class='form-control temp_remarks ' name='journal[temp_remarks][]' value='" + remarks + "'></td>";
            appendTxt += "<td style='text-align: center;'><input type='text' class='form-control temp_amount' name='journal[temp_amount][]' onkeyup='calculateGrandTotal();' value='" + amount + "'></td>";
            appendTxt += "<td style='text-align: center;'><button title=\"remove\"  type=\"button\" class=\"rdelete dltBtn btn btn-danger btn-md\" onclick=\"deleteRows($(this))\"><i class=\"icon-trash\"></i></button></td>";
            appendTxt += "</tr>";

            var tbodyRow = $('#table-data-list tbody tr.cartList').length;
            if (tbodyRow >= 1)
                $("#table-data-list tbody tr:last").after(appendTxt);
            else
                $("#table-data-list tbody").append(appendTxt);

        }

        $(document).on('input keyup drop paste', ".temp_amount", function (e) {
            calculateRowTotalOnChange();
        });

        function calculateGrandTotal() {
            var grand_total = 0;
            $('#table-data-list .temp_amount').each(function () {
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
                    var temp_return_price = nanCheck(parseFloat($(this).closest('tr').find(".temp_return_price").val()));
                    var temp_return_qty = nanCheck(parseFloat($(this).closest('tr').find(".temp_return_qty").val()));
                    var temp_row_return_price = nanCheck(parseFloat($(this).closest('tr').find(".temp_row_return_price").val()));

                    // console.log("MIN: " + temp_min_sell_price + ", SP: " + temp_sell_price);
                    if (temp_return_qty <= 0) {
                        temp_return_qty = 1;
                        $(this).closest('tr').find(".temp_return_qty ").val(temp_return_qty);
                    }

                    if (temp_return_qty <= 0) {
                        temp_return_qty = 1;
                        $(this).closest('tr').find(".temp_return_qty ").val(temp_return_qty);
                        toastr.warning("purchase qty exceeded 0!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    }
                    var row_total = temp_return_qty * temp_return_price;

                    $(this).closest('tr').find(".temp_row_return_price").val(row_total.toFixed(2));
                }
            );
            calculateGrandTotal();
        }


        function deleteRows(element) {
            var result = confirm("Are you sure you want to Delete?");
            if (result) {
                var temp_item_id = element.parents('tr').find('.temp_ca').html();
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
            $('form#mr-form').submit(function (e) {
                e.preventDefault();
                // Get the Login Name value and trim it
                var date = $.trim($('#date').val());
                var store_id = 1;
                var supplier_id = $.trim($('#supplier_id').val());
                var invoice_no = $.trim($('#invoice_no').val());
                var invoice_due = $.trim($('#invoice_due').val());
                var grand_total = nanCheck(parseFloat($.trim($('#grand_total').val())));

                if (date === '') {
                    toastr.warning(" Please select  date!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }
                if (store_id === '') {
                    toastr.warning(" Please select  store!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }
                if (supplier_id === '') {
                    toastr.warning(" Please select  customer!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }

                if (invoice_no === '' || invoice_no <= 0) {
                    toastr.warning(" Please select a PO!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }

                if (invoice_due === '' || invoice_due <= 0) {
                    toastr.warning(" Selected PO have no due!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }

                if (invoice_due < grand_total) {
                    toastr.warning(" Grand total exceeded PO due amount!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }

                var rowCount = $('#table-data-list tbody tr.cartList').length;
                if (nanCheck(rowCount) <= 0 || rowCount === 'undefined') {
                    toastr.warning(" Please add at least one item to grid!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }
                // console.log(grand_total);
                if (grand_total <= 0 || grand_total === "") {
                    toastr.warning(" Please insert return amount!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
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
                url: "{{ route('storeInventory.pr.store') }}",
                type: 'post',
                dataType: "json",
                cache: false,
                data: $('form').serialize(),
                beforeSend: function () {
                    if (supplier_id == "" || supplier_id == 0 || supplier_id == null) {
                        toastr.warning(" Please select Supplier!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
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
                        due = [];
                        $('#supplier_name').val('');
                        $('#supplier_id').val('');
                        $('#contact_no').val('');
                        $('#invoice_due').val('');
                        $('#invoice_no').html("");


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
            $('#ca_id').val(null).trigger('change');
            $('#amount').val("");
            $('#remarks').val("");
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

    <script src="{{asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/js/scripts/forms/select/form-select2.js')}}" type="text/javascript"></script>
@endpush
