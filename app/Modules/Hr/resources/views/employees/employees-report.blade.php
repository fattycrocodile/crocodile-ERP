@extends('layouts.app')
@section('title') {{ isset($pageTitle) ? $pageTitle : 'Employees Report' }} @endsection

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
                        <h4 class="card-title" id="basic-layout-form">EMPLOYEE REPORT CRITERIA</h4>
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
                            <form class="form" id="mr-form" action="{{route('hr.reports.employees-report-view')}}"
                                  method="post"
                                  autocomplete="off">
                                @csrf

                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="store_id">Store</label>
                                                <select id="store_id" name="store_id"
                                                        class="select2 form-control @error('store_id') is-invalid @enderror">
                                                    <option value="" selected="">Select Store</option>
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
                                                <label for="department_id">Department</label>
                                                <select id="department_id" name="department_id"
                                                        class="select2 form-control @error('department_id') is-invalid @enderror">
                                                    <option value="" selected="">Select Department</option>
                                                    @foreach($department as $key => $dep)
                                                        <option value="{{ $key }}"> {{ $dep->name }} </option>
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
                                                    <option value="" selected="">Select Designation</option>
                                                    @foreach($designation as $key => $dsg)
                                                        <option value="{{ $key }}"> {{ $dsg->name }} </option>
                                                    @endforeach
                                                </select>
                                                @error('designation_id')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="gender_id">Gender</label>
                                                <select id="gender_id" name="gender_id"
                                                        class="select2 form-control @error('gender_id') is-invalid @enderror">
                                                    <option value="" selected="">Select Gender</option>
                                                    @foreach($genders as $key => $gender)
                                                        <option value="{{ $key }}"> {{ $gender }} </option>
                                                    @endforeach
                                                </select>
                                                @error('gender_id')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="religion_id">Religion</label>
                                                <select id="religion_id" name="religion_id"
                                                        class="select2 form-control @error('religion_id') is-invalid @enderror">
                                                    <option value="" selected="">Select Religion</option>
                                                    @foreach($religions as $key => $religion)
                                                        <option value="{{ $key }}"> {{ $religion }} </option>
                                                    @endforeach
                                                </select>
                                                @error('religion_id')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="marital_status">Martial Status</label>
                                                <select id="marital_status" name="marital_status"
                                                        class="select2 form-control @error('marital_status') is-invalid @enderror">
                                                    <option value="" selected="">Select Marital Status</option>
                                                    @foreach($marital_status as $key => $status)
                                                        <option value="{{ $key }}"> {{ $status }} </option>
                                                    @endforeach
                                                </select>
                                                @error('marital_status')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="full_name">Name</label>
                                                <input type="text"
                                                       class="form-control @error('full_name') is-invalid @enderror"
                                                       id="full_name" name="full_name">
                                                @error('full_name')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="contact_no">Contact</label>
                                                <input type="text"
                                                       class="form-control @error('contact_no') is-invalid @enderror"
                                                       id="contact_no" name="contact_no">
                                                @error('contact_no')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select id="status" name="status"
                                                        class="select2 form-control @error('status') is-invalid @enderror">
                                                    <option value="" selected="">Select Status</option>
                                                        <option value="1"> Active </option>
                                                        <option value="0"> Inactive </option>
                                                </select>
                                                @error('status')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-actions center">
                                            <a type="button" class="btn btn-warning mb-1"
                                               href="{{route('hr.reports.employees-report')}}">
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
                    <h4 class="card-title">EMPLOYEE REPORT</h4>
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


        $(document).ready(function () {
            $(document).on('focus', ':input', function () {
                $(this).attr('autocomplete', 'off');
            });
        });

        $().ready(function () {
            $('form#mr-form').submit(function (e) {
                e.preventDefault();
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
                url: "{{ route('hr.reports.employees-report-view') }}",
                type: 'post',
                dataType: "json",
                cache: false,
                data: $('form').serialize(),
                beforeSend: function () {
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
