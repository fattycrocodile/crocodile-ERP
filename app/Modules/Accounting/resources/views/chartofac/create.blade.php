@extends('layouts.app')
@section('title') {{ $pageTitle }} @endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/selects/select2.min.css')}}">
@endpush

@section('content')
    @include('inc.flash')
    <div class="d-flex justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create New Categories</h4>
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
                        <form class="form" method="post" action="{{route('accounting.chartofaccounts.store')}}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="categoryName" >Chart Of Accounts Name <span class="required text-danger">*</span></label>
                                            <input type="text" id="categoryName" class="form-control  @error('name') is-invalid @enderror"
                                                   placeholder="Chart Of Accounts Name"
                                                   name="name" value="{{ old('name') }}">
                                            @error('name')<div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="parentCategory">Root Chart Of Accounts <span class="required text-danger">*</span></label>
                                            <select id="parentCategory" name="root_id" class="select2 form-control  @error('root_id') is-invalid @enderror">
                                                <option value="none" selected="" disabled="">Select Parent Head
                                                </option>
                                                @foreach($chartofacs as $chartofac)
                                                    <option value="{{$chartofac->id}}" {{ old('root_id')==$chartofac->id?'selected':''}}>{{$chartofac->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('root_id')<div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <a type="button" href="{{ route('accounting.chartofaccounts.index') }}"
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
@endsection

@push('scripts')
    <script src="{{asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/js/scripts/forms/select/form-select2.js')}}" type="text/javascript"></script>
@endpush
