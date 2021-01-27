@extends('layouts.app')
@section('title') {{ $pageTitle }} @endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/selects/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/daterange/daterangepicker.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/pickadate/pickadate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/pickers/daterange/daterange.css')}}">
@endpush

@section('content')
    @include('inc.flash')
    <div class="d-flex justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add New Holidays</h4>
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
                        <form class="form" method="post" action="{{route('hr.holidaysetup.update',$holidays->id)}}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="categoryName">Holiday Name</label>
                                            <input type="text" id="categoryName"
                                                   class="form-control @error('type') is-invalid @enderror"
                                                   placeholder="Holiday Name" value="{{ old('type')?old('type'):$holidays->type }}"
                                                   name="type">
                                            @error('type')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="parentCategory">Holiday Date</label>
                                            <div class='input-group date' id='datetimepicker1' data-provide="datepicker">
                                                <input type='text' name="date" value="{{old('date')?old('date'):$holidays->date}}" class="form-control @error('date') is-invalid @enderror" data-date-format="Y-MM-DD"/>
                                                <div class="input-group-append">
                                                <span class="input-group-text">
                                                  <span class="fa fa-calendar"></span>
                                                </span>
                                                </div>
                                            </div>
                                            @error('date')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="form-actions">
                                    <a type="button" href="{{ route('hr.holidaysetup.index') }}"
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
@endpush
