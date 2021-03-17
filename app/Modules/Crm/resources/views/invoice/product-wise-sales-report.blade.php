@extends('layouts.app')
@section('title') {{ isset($pageTitle) ? $pageTitle : 'Product Wise Sales Report' }} @endsection

@push('styles')
    <!-- CSS -->
    <style>
        .ui-datepicker {
            z-index: 999 !important;
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
                        <h4 class="card-title" id="basic-layout-form">PRODUCT WISE SALES REPORT CRITERIA</h4>
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
                            <form class="form" id="mr-form"
                                  action="{{route('crm.reports.product-wise-sales-view')}}"
                                  method="post"
                                  autocomplete="off">
                                @csrf

                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="start_date">Start Date</label>
                                                <input type="text"
                                                       class="form-control @error('start_date') is-invalid @enderror"
                                                       id="start_date" value="{!! date('Y-m-01') !!}" name="start_date"
                                                       required>
                                                @error('start_date')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="end_date">End Date</label>
                                                <input type="text"
                                                       class="form-control @error('end_date') is-invalid @enderror"
                                                       id="end_date" value="{!! date('Y-m-d') !!}" name="end_date"
                                                       required>
                                                @error('end_date')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>

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
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-actions center">
                                        <a type="button" class="btn btn-warning mb-1"
                                           href="{{route('crm.reports.product-wise-sales')}}">
                                            <i class="ft-refresh-ccw"></i> Reload
                                        </a>
                                        <button type="submit" class="btn btn-primary mb-1 search-btn"
                                                name="report-view"
                                                id="report-view">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                        <button type="button" class="btn btn-success mb-1 loading-text"
                                                style="display: none;">
                                            <i class="fa fa-spinner fa-pulse fa-fw"></i> Please wait..
                                        </button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <section class="row report-view-section" style="display: none;">
        <div class="col-sm-12">
            <div id="kick-start" class="card">
                <div class="card-header">
                    <h4 class="card-title">SALES REPORT</h4>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <div class="card-text report-result">
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
        function nanCheck(value) {
            return isNaN(value) ? 0 : value;
        }

        function isValidCode(code, codes) {
            return ($.inArray(code, codes) > -1);
        }

        // datepicker
        $(function () {
            $("#start_date").datepicker({
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
            $("#end_date").datepicker({
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


        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        // customer name wise search start
        $("#product_name").autocomplete({
            minLength: 1,
            autoFocus: true,
            source: function (request, response) {
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
            },
            focus: function (event, ui) {
                // console.log(event);
                // console.log(ui);
                return false;
            },
            select: function (event, ui) {
                if (ui.item.value != '' || ui.item.value > 0) {
                    $('#product_name').val(ui.item.name);
                    $('#product_code').val(ui.item.code);
                    $('#product_id').val(ui.item.value);
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
            },
            focus: function (event, ui) {
                // console.log(event);
                // console.log(ui);
                return false;
            },
            select: function (event, ui) {
                if (ui.item.value != '' || ui.item.value > 0) {
                    $('#product_name').val(ui.item.name);
                    $('#product_code').val(ui.item.code);
                    $('#product_id').val(ui.item.value);
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

        function resetSupplier() {
            $('#supplier_name').val("");
            $('#supplier_id').val("");
            $('#contact_no').val("");
        }

        $(document).ready(function () {
            $(document).on('focus', ':input', function () {
                $(this).attr('autocomplete', 'off');
            });
        });

        $().ready(function () {
            $('form#mr-form').submit(function (e) {
                e.preventDefault();
                // Get the Login Name value and trim it
                var start_date = $.trim($('#start_date').val());
                var end_date = $.trim($('#end_date').val());

                if (start_date === '') {
                    toastr.warning(" Please select  start date!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }
                if (end_date === '') {
                    toastr.warning(" Please select  end date!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }

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
                url: "{{ route('crm.reports.product-wise-sales-view') }}",
                type: 'post',
                dataType: "json",
                cache: false,
                data: $('form').serialize(),
                beforeSend: function () {
                    if (start_date === "" || end_date === "") {
                        toastr.warning(" Please select date range!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                        return false;
                    }
                    $(".loading-text").show();
                    $(".search-btn").hide();
                },
                success: function (result) {
                    $(".report-view-section").show();
                    $('.report-result').html(result.html);
                    $(".loading-text").hide();
                    $(".search-btn").show();
                },
                error: function (xhr, textStatus, thrownError) {
                    alert(xhr + "\n" + textStatus + "\n" + thrownError);
                    $(".spinner-div").hide();
                    $(".report-view-section").hide();
                    $(".loading-text").hide();
                    $(".search-btn").show();
                }
            }).done(function (data) {
            }).fail(function (jqXHR, textStatus) {
                $(".loading-text").hide();
                $(".search-btn").show();
                $(".report-view-section").hide();
            });
        }

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
