@extends('layouts.app')
@section('title') {{ isset($pageTitle) ? $pageTitle : 'Salary Entry' }} @endsection

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
                        <h4 class="card-title" id="basic-layout-form">Salary Info</h4>
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
                            <form class="form" id="mr-form" action="{{route('hr.salary.create')}}" method="post"
                                  autocomplete="off">
                                @csrf

                                <div class="form-body">
                                    <h4 class="form-section"><i class="ft-user"></i> Employee Info</h4>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="effective_date">Effective Date</label>
                                                <input type="text"
                                                       class="form-control @error('effective_date') is-invalid @enderror"
                                                       id="effective_date" value="{!! date('Y-m-d') !!}" name="effective_date" required>
                                                @error('effective_date')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="department_id">Department</label>
                                                <select id="department_id" name="department_id"
                                                        class="select2 form-control @error('department_id') is-invalid @enderror">
                                                    <option value="" selected="">Select Department</option>
                                                    @foreach($departments as $key => $dep)
                                                        <option value="{{ $dep->id }}"> {{ $dep->name }} </option>
                                                    @endforeach
                                                </select>
                                                @error('department_id')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="designation_id">Designation</label>
                                                <select id="designation_id" name="designation_id"
                                                        class="select2 form-control @error('designation_id') is-invalid @enderror">
                                                    <option value="" selected="">Select Department</option>
                                                    @foreach($designations as $key => $dep)
                                                        <option value="{{ $dep->id }}"> {{ $dep->name }} </option>
                                                    @endforeach
                                                </select>
                                                @error('designation_id')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="full_name">Name</label>
                                                <input type="text"
                                                       class="form-control @error('full_name') is-invalid @enderror"
                                                       id="full_name">
                                                <input type="hidden"
                                                       class="form-control @error('employee_id') is-invalid @enderror"
                                                       id="employee_id" name="employee_id">
                                                @error('employee_id')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group" style="margin-top: 26px;">
                                                <button id="action" class="btn btn-primary btn-md" type="button"
                                                        onclick="getEmployeeList()">
                                                    <i class="icon-magnifier"></i>
                                                </button>
                                                <button id="reset" class="btn btn-warning btn-md" type="button">
                                                    <i class="icon-refresh"></i>
                                                </button>
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
        $(function () {
            $("#effective_date").datepicker({
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
        // employee name wise search start
        $("#full_name").autocomplete({
            minLength: 1,
            autoFocus: true,
            source: function (request, response) {
                var department_id = $("#department_id").val();
                var designation_id = $("#designation_id").val();
                $.ajax({
                    url: "{{ route('employee.list.autocomplete') }}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        search: request.term,
                        department_id: department_id,
                        designation_id: designation_id,
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
                    $('#full_name').val(ui.item.label);
                    $('#employee_id').val(ui.item.value);
                    $('#department_id').val(ui.item.department_id);
                    $('#designation_id').val(ui.item.designation_id);
                }
                return false;
            },
        });
        // employee name wise search end


        $(document).ready(function () {
            $(document).on('focus', ':input', function () {
                $(this).attr('autocomplete', 'off');
            });
        });

        function getEmployeeList() {
            var effective_date = $("#effective_date").val();
            var designation_id = $("#designation_id").val();
            var department_id = $("#department_id").val();
            var employee_id = $("#employee_id").val();
            $.ajax({
                url: "{{ route('employee.list.salary-setup') }}",
                type: 'post',
                dataType: "json",
                cache: false,
                data: {
                    _token: CSRF_TOKEN,
                    department_id: department_id,
                    designation_id: designation_id,
                    employee_id: employee_id,
                    effective_date: effective_date,
                },
                beforeSend: function () {
                    $('#invoice-infos').html("");
                    $(".spinner-div").show();
                },
                success: function (result) {
                    if (result.error == false) {
                        //user_jobs div defined on page
                        $('#invoice-infos').html(result.data);
                    } else {
                        $(".invoice-infos").html("");
                        {{--$('#user_jobs').html(data.html + '{{ $user->username }}');--}}
                    }
                    $(".spinner-div").hide();
                },
                error: function (xhr, textStatus, thrownError) {
                    alert(xhr + "\n" + textStatus + "\n" + thrownError);
                    $(".spinner-div").hide();
                    $(".invoice-infos").html("");
                }
            }).done(function (data) {
                // $("#stock_qty").val(data.closing_balance);
            }).fail(function (jqXHR, textStatus) {
                $(".spinner-div").hide();
                $(".invoice-infos").html("");
            });
        }


        $().ready(function () {
            $('form#mr-form').submit(function (e) {
                e.preventDefault();
                var effective_date = $.trim($('#effective_date').val());
                if (effective_date === '') {
                    toastr.warning(" Please select  effective date!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }
                ajaxSave();
            });
        });

        function ajaxSave() {
            var effective_date = $("#effective_date").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('hr.salary.store') }}",
                type: 'post',
                dataType: "json",
                cache: false,
                data: $('form').serialize(),
                beforeSend: function () {
                    if (effective_date == "") {
                        toastr.warning(" Please select effective date!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                        return false;
                    }
                    $('#invoice-infos').html("");
                    $(".spinner-div").show();
                },
                success: function (result) {
                    if (result.error === false) {
                        toastr.success(result.message, 'Message <i class="fa fa-bell faa-ring animated"></i>')
                    } else {
                        toastr.error(result.message, 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    }
                    $(".spinner-div").hide();
                    $(".invoice-infos").html("");
                },
                error: function (xhr, textStatus, thrownError) {
                    alert(xhr + "\n" + textStatus + "\n" + thrownError);
                    // $(".spinner-div").hide();
                    // $(".invoice-infos").html("");
                }
            }).done(function (data) {
                // console.log("REQUEST DONE;");
            }).fail(function (jqXHR, textStatus) {
                // console.log("REQUEST FAILED;");
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

        $("#reset").click(function () {
            clearSearch();
        });

        function clearSearch() {
            $("#department_id").val("");
            $("#designation_id").val("");
            $("#employee_id").val("");
            $("#full_name").val("");
        }
    </script>
@endpush
