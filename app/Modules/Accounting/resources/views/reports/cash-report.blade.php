@extends('layouts.app')
@section('title') {{ isset($pageTitle) ? $pageTitle : 'Liquid Money Report' }} @endsection

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
                        <h4 class="card-title" id="basic-layout-form">LIQUID MONEY REPORT CRITERIA</h4>
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
                                  action="{{route('accounting.reports.liquid-money-view')}}"
                                  method="post"
                                  autocomplete="off">
                                @csrf

                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="date">Select Date</label>
                                                <input type="text"
                                                       class="form-control @error('date') is-invalid @enderror"
                                                       id="date" value="{!! date('Y-m-d') !!}" name="date"
                                                       required>
                                                @error('date')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>


                                        <div class="d-flex align-items-end" style="margin-bottom:0.5%;">
                                            <button type="submit" class="btn btn-primary mb-1 search-btn"
                                                    name="report-view"
                                                    id="report-view">
                                                <i class="fa fa-search"></i> Search
                                            </button>

                                            <button type="button" class="btn btn-success mb-1 loading-text"
                                                    style="display: none;">
                                                <i class="fa fa-spinner fa-pulse fa-fw"></i> Please wait..
                                            </button>

                                            <a type="button" class="btn btn-warning mb-1"
                                               href="{{route('accounting.reports.profit-and-loss-report')}}">
                                                <i class="ft-refresh-ccw"></i> Reload
                                            </a>
                                        </div>
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
                    <h4 class="card-title">PROFIT AND LOSS REPORT</h4>
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
            $('#date').datepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                altFormat: "DD, d MM, yy",
                prevText: "click for previous months",
                nextText: "click for next months",
                dateFormat: 'yy-mm-dd',
            });
        });

        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        // customer name wise search start


        $(document).ready(function () {
            $(document).on('focus', ':input', function () {
                $(this).attr('autocomplete', 'off');
            });
        });

        $().ready(function () {
            $('form#mr-form').submit(function (e) {
                e.preventDefault();
                // Get the Login Name value and trim it
                var date = $.trim($('#date').val());
                if (date === '') {
                    toastr.warning(" Please select  date!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }
                ajaxSave();
            });
        });

        function ajaxSave() {
            var date = $("#date").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('accounting.reports.liquid-money-view') }}",
                type: 'post',
                dataType: "json",
                cache: false,
                data: $('form').serialize(),
                beforeSend: function () {
                    if (date === "") {
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
