@extends('layouts.app')
@section('title') {{ isset($pageTitle) ? $pageTitle : "EDIT SALARY" }} @endsection


@section('content')
    @include('inc.flash')
    <div class="d-flex justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">UPDATE SALARY</h4>
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
                        <form class="form" method="post" action="{{route('hr.salary.update',$data->id)}}"
                              enctype="multipart/form-data">
                            @method('post')
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="employee_name">Employee Name</label>
                                            <input type="text" id="employee_name" class="form-control"
                                                   placeholder="Employee Name" readonly disabled
                                                   name="employee_name"
                                                   value="{!! old('employee_name', $data->employee->full_name)  !!}"
                                                   @error('employee_name') is-invalid @enderror>
                                            @error('employee_name')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="department_id">Department</label>
                                            <input type="text" id="department_id" class="form-control"
                                                   placeholder="Department" readonly disabled
                                                   name="department_id"
                                                   value="{!! isset($data->employee->department->name) ? $data->employee->department->name : "N/A"  !!}"
                                                   @error('department_id') is-invalid @enderror>
                                            @error('department_id')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="designation_id">Designation</label>
                                            <input type="text" id="designation_id" class="form-control"
                                                   placeholder="Designation" readonly disabled
                                                   name="designation_id"
                                                   value="{!! isset($data->employee->designation->name) ? $data->employee->designation->name : "N/A"  !!}"
                                                   @error('designation_id') is-invalid @enderror>
                                            @error('designation_id')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="effective_date">Effective Date</label>
                                            <input type="text"
                                                   class="form-control @error('effective_date') is-invalid @enderror"
                                                   id="effective_date"
                                                   value="{!! old('employee_name', $data->effective_date)  !!}"
                                                   name="effective_date" required>
                                            @error('effective_date')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="basic_amount">Basic Amount</label>
                                            <input type="text"
                                                   class="form-control basic_amount @error('basic_amount') is-invalid @enderror"
                                                   id="effective_date"
                                                   value="{!! old('basic_amount', $data->basic_amount)  !!}"
                                                   name="basic_amount">
                                            @error('basic_amount')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="home_allowance">Home Allow.</label>
                                            <input type="text"
                                                   class="form-control home_allowance @error('home_allowance') is-invalid @enderror"
                                                   id="home_allowance"
                                                   value="{!! old('home_allowance', $data->home_allowance)  !!}"
                                                   name="home_allowance">
                                            @error('home_allowance')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="medical_allowance">Medical Allow.</label>
                                            <input type="text"
                                                   class="form-control medical_allowance @error('medical_allowance') is-invalid @enderror"
                                                   id="medical_allowance"
                                                   value="{!! old('medical_allowance', $data->medical_allowance)  !!}"
                                                   name="medical_allowance">
                                            @error('medical_allowance')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="ta">TA</label>
                                            <input type="text"
                                                   class="form-control ta @error('ta') is-invalid @enderror"
                                                   id="ta"
                                                   value="{!! old('ta', $data->ta)  !!}"
                                                   name="ta">
                                            @error('ta')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="da">DA</label>
                                            <input type="text"
                                                   class="form-control da @error('da') is-invalid @enderror"
                                                   id="da"
                                                   value="{!! old('da', $data->da)  !!}"
                                                   name="da">
                                            @error('da')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="other_allowances">Others Allow.</label>
                                            <input type="text"
                                                   class="form-control other_allowances @error('other_allowances') is-invalid @enderror"
                                                   id="other_allowances"
                                                   value="{!! old('other_allowances', $data->other_allowances)  !!}"
                                                   name="other_allowances">
                                            @error('other_allowances')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="row_total">Total</label>
                                            <input type="text"
                                                   class="form-control total_salary @error('total_salary') is-invalid @enderror"
                                                   id="total_salary"
                                                   value="{!! old('row_total', $data->basic_amount + $data->home_allowance + $data->medical_allowance + $data->ta + $data->da + $data->other_allowances)  !!}"
                                                   name="total_salary" required readonly min="1">
                                            @error('total_salary')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <a type="button" class="btn btn-outline-warning mr-1"
                                       href="{{ route('hr.salary.update', ['id' => $data->id]) }}">
                                        <i class="ft-x"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="ft-check"></i> Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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


        $(document).ready(function () {
            $(document).on('focus', ':input', function () {
                $(this).attr('autocomplete', 'off');
            });
        });

        function nanCheck(value) {
            return isNaN(value) ? 0 : value;
        }

        function isValidCode(code, codes) {
            return ($.inArray(code, codes) > -1);
        }

        // Restricts input for the set of matched elements to the given inputFilter function.
        $(document).on('input keyup  drop paste', ".basic_amount, .home_allowance, .medical_allowance, .ta, .da, .other_allowances, .total_salary", function (evt) {
            var self = $(this);
            self.val(self.val().replace(/[^0-9\.]/g, ''));
            if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) {
                evt.preventDefault();
            }
            calculateTotal();
        });

        function calculateTotal(){
            var temp_basic_amount = nanCheck(parseFloat($(".basic_amount").val()));
            var temp_home_allowance = nanCheck(parseFloat($(".home_allowance").val()));
            var temp_medical_allowance = nanCheck(parseFloat($(".medical_allowance").val()));
            var temp_ta = nanCheck(parseFloat($(".ta").val()));
            var temp_da = nanCheck(parseFloat($(".da").val()));
            var temp_other_allowances = nanCheck(parseFloat($(".other_allowances").val()));
            var row_total = temp_basic_amount + temp_home_allowance + temp_medical_allowance + temp_ta + temp_da + temp_other_allowances;
            if (row_total > 0) {
                $(".total_salary").val(row_total.toFixed(2));
            }
        }
    </script>


@endpush


