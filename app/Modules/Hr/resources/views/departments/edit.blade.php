@extends('layouts.app')
@section('title') {{ $pageTitle }} @endsection

@push('styles')

@endpush

@section('content')
    @include('inc.flash')
    <section class="basic-elements">
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
                            <form class="form" method="post"
                                  action="{{route('hr.departments.update',$department->id)}}">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="categoryName">Departments Name <span
                                                        class="required text-danger">*</span></label>
                                                <input type="text" id="categoryName"
                                                       class="form-control @error('name') is-invalid @enderror"
                                                       placeholder="Departments Name"
                                                       value="{{ old('name')?old('name'):$department->name }}"
                                                       name="name">
                                                @error('name')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="status">Departments Status</label>
                                                <select id="status" name="status"
                                                        class="select2 form-control @error('status') is-invalid @enderror">
                                                    <option value="none" selected="" disabled="">Select Status
                                                    </option>
                                                    <option value="0" {{ $department->status==0?'selected':'' }}>
                                                        Deactive
                                                    </option>
                                                    <option value="1" {{ $department->status==1?'selected':'' }}>Active
                                                    </option>
                                                </select>
                                                @error('status')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-actions">
                                        <a type="button" href="{{ route('hr.departments.index') }}"
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

@endpush
