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
                        <h4 class="card-title" id="basic-layout-form">Purchase Info</h4>
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
                            <form class="form" id="mr-form" action="{{route('storeInventory.pr.store')}}" method="post"
                                  autocomplete="off">
                                @csrf

                                <div class="form-body">
                                    <h4 class="form-section"><i class="ft-user"></i> Supplier Info</h4>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="supplier_name">Supplier Name</label>
                                                <input type="text"
                                                       class="form-control @error('supplier_name') is-invalid @enderror"
                                                       id="supplier_name" required>
                                                <input type="hidden"
                                                       class="form-control @error('supplier_id') is-invalid @enderror"
                                                       id="supplier_id" name="supplier_id" required>
                                                @error('supplier_id')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="contact_no">Contact</label>
                                                <input type="text" class="form-control" id="contact_no" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group" style="margin-top: 26px;">
                                                <button id="action" class="btn btn-primary btn-md" type="button"
                                                        onclick="getDueInvoice()">
                                                    <i class="icon-magnifier"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="contact_no">Select Invoice</label>
                                                <input type="text" class="form-control" id="contact_no" value="">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="contact_no">Invoice Due : </label>
                                                <input type="hidden" class="form-control" id="contact_no" value="">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="spinner-div text-center" style="display: none;">
                                        <button type="button" class="btn btn-lg btn-success mb-1">
                                            <i class="fa fa-spinner fa-pulse fa-fw"></i> Please wait..
                                        </button>
                                    </div>
                                    <div class="row" id="invoice-infos">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade text-left" id="xlarge" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16"
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
                                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
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
        // customer name wise search start
        $("#supplier_name").autocomplete({
            minLength: 1,
            autoFocus: true,
            source: function (request, response) {
                $.ajax({
                    url: "{{ route('supplier.name.autocomplete') }}",
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
            },
            focus: function (event, ui) {
                // console.log(event);
                // console.log(ui);
                return false;
            },
            select: function (event, ui) {
                if (ui.item.value != '' || ui.item.value > 0) {
                    $('#supplier_name').val(ui.item.name);
                    $('#supplier_id').val(ui.item.value);
                    $('#contact_no').val(ui.item.contact_no);
                } else {
                    resetSupplier();
                }
                return false;
            },
        }).data("ui-autocomplete")._renderItem = function (ul, item) {

            var inner_html = '<div>' + item.label + '</div>';
            return $("<li>")
                .data("item.autocomplete", item)
                .append(inner_html)
                .appendTo(ul);
        };
        // customer name wise search end

        // customer name wise search start
        $("#contact_no").autocomplete({
            minLength: 1,
            autoFocus: true,
            source: function (request, response) {
                $.ajax({
                    url: "{{ route('supplier.contact.autocomplete') }}",
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
            },
            focus: function (event, ui) {
                // console.log(event);
                // console.log(ui);
                return false;
            },
            select: function (event, ui) {
                if (ui.item.value != '' || ui.item.value > 0) {
                    $('#supplier_name').val(ui.item.name);
                    $('#supplier_id').val(ui.item.value);
                    $('#contact_no').val(ui.item.contact_no);
                } else {
                    resetSupplier();
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

        function getDueInvoice() {
            var supplier_id = $("#supplier_id").val();
            $.ajax({
                url: "{{ route('payment.purchase.due_purchase_due') }}",
                type: 'post',
                dataType: "json",
                cache: false,
                data: {
                    _token: CSRF_TOKEN,
                    supplier_id: supplier_id,
                },
                beforeSend: function () {
                    if (supplier_id == "" || supplier_id == 0 || supplier_id == null) {
                        toastr.warning(" Please select Supplier!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                        return false;
                    }
                },
                success: function (data) {
                    if (data.success == true) {
                        //user_jobs div defined on page
                        console.log(data);
                        //$('#invoice-infos').html(data.html);
                    } else {
                        $(".invoice-infos").html("");
                    }
                },
                error: function (xhr, textStatus, thrownError) {
                    alert(xhr + "\n" + textStatus + "\n" + thrownError);
                }
            }).done(function (data) {
                // $("#stock_qty").val(data.closing_balance);
            }).fail(function (jqXHR, textStatus) {
            });
        }


        $().ready(function () {
            $('form#mr-form').submit(function (e) {
                e.preventDefault();
                // Get the Login Name value and trim it
                var date = $.trim($('#date').val());
                var store_id = 1;
                var supplier_id = $.trim($('#supplier_id').val());
                var payment_method = $.trim($('#payment_method').val());
                var bank_id = $.trim($('#bank_id').val());
                var cheque_no = $.trim($('#cheque_no').val());
                var cheque_date = $.trim($('#cheque_date').val());
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

                if (payment_method === '' || payment_method <= 0) {
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

                var rowCount = $('#table-data-list tbody tr.cartList').length;
                if (nanCheck(rowCount) <= 0 || rowCount === 'undefined') {
                    toastr.warning(" Please add at least one item to grid!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }
                // console.log(grand_total);
                if (grand_total <= 0 || grand_total === "") {
                    toastr.warning(" Please insert mr amount!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
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
                url: "{{ route('accounting.payment.store') }}",
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
                    if(result.error === false){
                        $(".print-success-msg").css('display','block');
                        $(".print-success-msg").html(result.message);
                        $('.modal-body').html(result.data);
                        $('#xlarge').modal('show');
                        flashMessage('success');
                    }else{
                        printErrorMsg(result.data);
                        flashMessage('error');
                    }
                    $(".spinner-div").hide();
                    $(".invoice-infos").html("");
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

        function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }


        function resetSupplier() {
            $('#supplier_name').val("");
            $('#supplier_id').val("");
            $('#contact_no').val("");
        }

        function flashMessage(value = 'success'){
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
