@extends('layouts.app')
@section('title') {{ $pageTitle }} @endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/selects/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/selects/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/daterange/daterangepicker.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/pickadate/pickadate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/pickers/daterange/daterange.css')}}">

@endpush

@section('content')
    @include('inc.flash')
    <section class="basic-elements">
        <div class="d-flex justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit a Employee</h4>
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
                        <form class="form" method="post" action="{{route('hr.employees.update',$employee->id)}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="f_name">First Name <span class="required text-danger">*</span></label>
                                            <input type="text" id="f_name"
                                                   class="form-control @error('f_name') is-invalid @enderror"
                                                   placeholder="First Name" value="{{ old('f_name')?old('f_name'):$employee->f_name }}"
                                                   name="f_name">
                                            @error('f_name')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="l_name">Last Name </label>
                                            <input type="text" id="l_name"
                                                   class="form-control @error('l_name') is-invalid @enderror"
                                                   placeholder="Last Name" value="{{ old('l_name')?old('l_name'):$employee->l_name }}"
                                                   name="l_name">
                                            @error('l_name')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="full_name">Employee Full Name <span class="required text-danger">*</span></label>
                                    <input type="text" id="full_name"
                                           class="form-control @error('full_name') is-invalid @enderror"
                                           placeholder="Employee Full Name" value="{{ old('full_name')?old('full_name'):$employee->full_name }}"
                                           name="full_name">
                                    @error('full_name')
                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email </label>
                                            <input type="email" id="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   placeholder="Email" value="{{ old('email')?old('email'):$employee->email }}"
                                                   name="email">
                                            @error('email')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact_no">Phone No <span class="required text-danger">*</span></label>
                                            <input type="text" id="contact_no"
                                                   class="form-control @error('contact_no') is-invalid @enderror"
                                                   placeholder="Phone No" value="{{ old('contact_no')?old('contact_no'):$employee->contact_no }}"
                                                   name="contact_no">
                                            @error('contact_no')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gender">Gender <span class="required text-danger">*</span></label>
                                            <select id="gender" name="gender"
                                                    class="select2 form-control @error('gender') is-invalid @enderror">
                                                <option value="none" selected="" disabled="">Select Gender
                                                </option>
                                                @foreach($genders as $gender)
                                                    <option
                                                        value="{{$gender->code}}" {{ (old('gender')?old('gender'):$employee->gender)==$gender->code?'selected':'' }}>{{$gender->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('gender')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="religion">Religion <span class="required text-danger">*</span></label>
                                            <select id="religion" name="religion"
                                                    class="select2 form-control @error('religion') is-invalid @enderror">
                                                <option value="none" selected="" disabled="">Select Religion
                                                </option>
                                                @foreach($religions as $religion)
                                                    <option
                                                        value="{{$religion->code}}" {{ (old('religion')?old('religion'):$employee->religion)==$religion->code?'selected':'' }}>{{$religion->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('religion')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="marital_status">Marital Status <span class="required text-danger">*</span></label>
                                            <select id="marital_status" name="marital_status"
                                                    class="select2 form-control @error('marital_status') is-invalid @enderror">
                                                <option value="none" selected="" disabled="">Select Marital Status
                                                </option>
                                                @foreach($marital_status as $maritalstatus)
                                                    <option
                                                        value="{{$maritalstatus->code}}" {{ (old('marital_status')?old('marital_status'):$employee->marital_status)==$maritalstatus->code?'selected':'' }}>{{$maritalstatus->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('marital_status')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="datetimepicker1">Date Of Birth <span class="required text-danger">*</span></label>
                                            <div class='input-group date' id='datetimepicker1' data-provide="datepicker">
                                                <input type='text' name="dob" value="{{old('dob')?old('dob'):$employee->dob}}" class="form-control @error('dob') is-invalid @enderror" data-date-format="Y-MM-DD" autocomplete="off"/>
                                                <div class="input-group-append">
                                                <span class="input-group-text">
                                                  <span class="fa fa-calendar"></span>
                                                </span>
                                                </div>
                                            </div>
                                            @error('dob')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="department_id">Department <span class="required text-danger">*</span></label>
                                            <select id="department_id" name="department_id"
                                                    class="select2 form-control @error('department_id') is-invalid @enderror">
                                                <option value="none" selected="" disabled="">Select Department
                                                </option>
                                                @foreach($departments as $department)
                                                    <option
                                                        value="{{$department->id}}" {{ (old('department_id')?old('department_id'):$employee->department_id)==$department->id?'selected':'' }}>{{$department->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('department_id')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="designation_id">Designation <span class="required text-danger">*</span></label>
                                            <select id="designation_id" name="designation_id"
                                                    class="select2 form-control @error('designation_id') is-invalid @enderror">
                                                <option value="none" selected="" disabled="">Select Designation
                                                </option>
                                                @foreach($designations as $designation)
                                                    <option
                                                        value="{{$designation->id}}" {{ (old('designation_id')?old('designation_id'):$employee->designation_id)==$designation->id?'selected':'' }}>{{$designation->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('designation_id')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="datetimepicker1">Appointment Date </label>
                                            <div class='input-group date' id='datetimepicker1' data-provide="datepicker">
                                                <input type='text' name="appointment_date" value="{{old('appointment_date')?old('appointment_date'):$employee->appointment_date}}" class="form-control @error('appointment_date') is-invalid @enderror" data-date-format="Y-MM-DD" autocomplete="off" placeholder="Appointment Date"/>
                                                <div class="input-group-append">
                                                <span class="input-group-text">
                                                  <span class="fa fa-calendar"></span>
                                                </span>
                                                </div>
                                            </div>
                                            @error('appointment_date')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="datetimepicker1">Joining Date <span class="required text-danger">*</span></label>
                                            <div class='input-group date' id='datetimepicker1' data-provide="datepicker">
                                                <input type='text' name="join_date" value="{{old('join_date')?old('join_date'):$employee->join_date}}" class="form-control @error('join_date') is-invalid @enderror" data-date-format="Y-MM-DD" autocomplete="off"/>
                                                <div class="input-group-append">
                                                <span class="input-group-text">
                                                  <span class="fa fa-calendar"></span>
                                                </span>
                                                </div>
                                            </div>
                                            @error('join_date')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="datetimepicker1">Permanent Date </label>
                                            <div class='input-group date' id='datetimepicker1' data-provide="datepicker">
                                                <input type='text' name="permanent_date" value="{{old('permanent_date')?old('permanent_date'):$employee->permanent_date}}" class="form-control @error('permanent_date') is-invalid @enderror" data-date-format="Y-MM-DD" autocomplete="off"/>
                                                <div class="input-group-append">
                                                <span class="input-group-text">
                                                  <span class="fa fa-calendar"></span>
                                                </span>
                                                </div>
                                            </div>
                                            @error('permanent_date')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="skills">Skills </label>
                                            <input type="text" id="skills"
                                                   class="form-control @error('skills') is-invalid @enderror"
                                                   placeholder="Skills" value="{{ old('skills')?old('skills'):$employee->skills }}"
                                                   name="skills">
                                            @error('skills')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="store_id">Store </label>
                                            <select id="store_id" name="store_id"
                                                    class="select2 form-control @error('store_id') is-invalid @enderror">
                                                <option value="none" selected="" disabled="">Select Store
                                                </option>
                                                @foreach($stores as $store)
                                                    <option
                                                        value="{{$store->id}}" {{ (old('store_id')?old('store_id'):$employee->store_id)==$store->id?'selected':'' }}>{{$store->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('store_id')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tin">TIN No </label>
                                            <input type="text" id="tin"
                                                   class="form-control @error('tin') is-invalid @enderror"
                                                   placeholder="TIN No" value="{{ old('tin')?old('tin'):$employee->tin }}"
                                                   name="tin">
                                            @error('tin')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="bank_acc_no">Bank Account No</label>
                                            <input type="text" id="bank_acc_no"
                                                   class="form-control @error('bank_acc_no') is-invalid @enderror"
                                                   placeholder="Bank Account No" value="{{ old('bank_acc_no')?old('bank_acc_no'):$employee->bank_acc_no }}"
                                                   name="bank_acc_no">
                                            @error('bank_acc_no')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="bank_name">Bank Name</label>
                                            <input type="text" id="bank_name"
                                                   class="form-control @error('bank_name') is-invalid @enderror"
                                                   placeholder="Bank Name" value="{{ old('bank_name')?old('bank_name'):$employee->bank_name }}"
                                                   name="bank_name">
                                            @error('bank_name')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="desc">Present Address </label>
                                    <textarea name="present_address" id="present_address" cols="50" rows="10"
                                              class="form-control @error('present_address') is-invalid @enderror">{{old('present_address')?old('present_address'):$employee->present_address}}</textarea>
                                    @error('present_address')
                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                </div>

                                <div class="form-group">
                                    <label for="desc">Permanent Address <span class="required text-danger">*</span></label>
                                    <textarea name="permanent_address" id="permanent_address" cols="50" rows="10"
                                              class="form-control @error('permanent_address') is-invalid @enderror">{{old('permanent_address')?old('permanent_address'):$employee->permanent_address}}</textarea>
                                    @error('permanent_address')
                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="image">Image <span class="required text-danger">*</span></label>
                                            <input type="file" id="image" class="form-control @error('image') is-invalid @enderror"
                                                   placeholder="Category Image"
                                                   name="image"
                                                   onchange="document.getElementById('imageview').src = window.URL.createObjectURL(this.files[0])">
                                            @error('image')<div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <img id="imageview" src="{{asset($employee->image)}}" alt="" width="100">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cv_file">CV File </label>
                                            <input type="file" id="cv_file" class="form-control @error('cv_file') is-invalid @enderror"
                                                   placeholder="CV File"
                                                   name="cv_file"
                                                   onchange="document.getElementById('fileview').innerText = this.files[0].name">
                                            @error('cv_file')<div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <p style="padding-top: 40px;" id="fileview" alt="" >
                                            @php
                                                $values = explode(".",$employee->cv_file);
                                            @endphp
                                            <?php
                                            if(isset($values[1])){
                                                echo $values[1];
                                            }

                                            if(isset($values[2])){
                                                echo "." . $values[2];
                                            }

                                            ?>
{{--                                            {{(isset($values[1]) ? $values[1] : "")(isset($values[1]) ? '.' .$values[2] : "")}}--}}
                                        </p>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <a type="button" href="{{ route('hr.employees.index') }}"
                                       class="btn btn-warning mr-1">
                                        <i class="ft-x"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-check-square-o"></i> Update
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
    <script src="{{asset('app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/js/scripts/forms/select/form-select2.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/pickadate/picker.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/pickadate/picker.date.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/pickadate/picker.time.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/pickadate/legacy.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/daterange/daterangepicker.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('app-assets/js/scripts/pickers/dateTime/bootstrap-datetime.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('app-assets/js/scripts/pickers/dateTime/pick-a-datetime.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/js/scripts/forms/select/form-select2.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/ckeditor/ckeditor.js')}}" type="text/javascript"></script>

    <script>
        $(function () {
            // instance, using default configuration.
            CKEDITOR.replace('present_address')
        })
        $(function () {
            // instance, using default configuration.
            CKEDITOR.replace('permanent_address')
        })

        $('.date').datetimepicker({});
    </script>
@endpush
