@extends('layouts.app')
@section('title') {{ $pageTitle }} @endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/selects/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css')}}">
@endpush

@section('content')
    @include('inc.flash')
    <section class="basic-elements">
        <div class="d-flex justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Apply for Leave</h4>
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
                <div class="card-content collpase show">
                    <div class="card-body">
                        <form class="form" method="post" action="{{route('hr.leaves.store')}}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="employee_name">Employee Name <span class="required text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('employee_id') is-invalid @enderror"
                                           id="employee_name" name="employee_name">
                                    <input type="hidden" name="employee_id" id="employee_id">
                                    @error('employee_id')
                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                </div>
                            </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="from_date">Date From <span class="required text-danger">*</span></label>
                                            <div class='input-group fromdate' id='datetimepicker1' data-provide="datepicker">
                                                <input type='text' name="from_date" value="{{old('from_date')}}" class="form-control @error('from_date') is-invalid @enderror" data-date-format="Y-MM-DD" autocomplete="off"/>
                                                <div class="input-group-append">
                                                <span class="input-group-text">
                                                  <span class="fa fa-calendar"></span>
                                                </span>
                                                </div>
                                            </div>
                                            @error('from_date')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="to_date">Date To <span class="required text-danger">*</span></label>
                                            <div class='input-group todate' id='datetimepicker1' data-provide="datepicker">
                                                <input type='text' name="to_date" value="{{old('to_date')}}" class="form-control @error('to_date') is-invalid @enderror" data-date-format="Y-MM-DD" autocomplete="off"/>
                                                <div class="input-group-append">
                                                <span class="input-group-text">
                                                  <span class="fa fa-calendar"></span>
                                                </span>
                                                </div>
                                            </div>
                                            @error('to_date')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                </div>


                                        <div class="form-group">
                                            <label for="subject">Subject <span class="required text-danger">*</span></label>
                                            <input type="text" id="subject"
                                                   class="form-control @error('subject') is-invalid @enderror"
                                                   placeholder="Application Subject" value="{{ old('subject') }}"
                                                   name="subject">
                                            @error('subject')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>


                                        <div class="form-group">
                                            <label for="desc">Description </label>
                                            <textarea name="description" id="desc" cols="50" rows="20"
                                                      class="form-control @error('description') is-invalid @enderror">{{old('description')}}</textarea>
                                            @error('description')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>


                                <div class="form-actions">
                                    <a type="button" href="{{ route('hr.leaves.index') }}"
                                       class="btn btn-warning mr-1">
                                        <i class="ft-x"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
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
    <script src="{{asset('assets/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('app-assets/js/scripts/pickers/dateTime/bootstrap-datetime.js')}}"
            type="text/javascript"></script>

    <script>
        $(function () {
            // instance, using default configuration.
            CKEDITOR.replace('desc')
        })

        var toStartDate = '';

        $('.fromdate').datetimepicker({
        }).on('dp.change', function (ev) {
            var toStartDate = new Date(ev.date.valueOf());

            $('.todate').datetimepicker({
                // minDate: toStartDate,
            });
        });




        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $("#employee_name").autocomplete({
            minLength: 1,
            autoFocus: true,
            source: function (request, response) {
                $.ajax({
                    url: "{{ route('employee.list.autocomplete') }}",
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
                return false;
            },
            select: function (event, ui) {
                if (ui.item.value != '' || ui.item.value > 0) {
                    $('#employee_name').val(ui.item.label);
                    $('#employee_id').val(ui.item.value);
                } else {
                    resetEmployee();
                }
                return false;
            },
        }).data("ui-autocomplete")._renderItem = function (ul, item) {

            var inner_html = '<div>' + item.label + ' (<i>' + item.designation + ')</i></div>';
            return $("<li>")
                .data("item.autocomplete", item)
                .append(inner_html)
                .appendTo(ul);
        };

        function resetEmployee() {
            $('#employee_id').val("");
            $('#employee_name').val("");
        }
    </script>

@endpush
