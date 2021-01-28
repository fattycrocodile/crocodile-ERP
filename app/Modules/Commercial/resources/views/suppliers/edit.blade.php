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
                    <h4 class="card-title">Create New Customers</h4>
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
                        <form class="form" method="post" action="{{route('commercial.suppliers.update',$data->id)}}">
                            @method('POST')
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="SupplierName">Supplier Name</label>
                                            <input type="text" id="SupplierName"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   value="{{old('name')?old('name'):$data->name}}"
                                                   placeholder="Supplier Name"
                                                   name="name">
                                            @error('name')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="SupplierContact">Supplier Contact</label>
                                            <input type="text" id="SupplierContact"
                                                   class="form-control @error('contact_no') is-invalid @enderror"
                                                   placeholder="Supplier Contact"
                                                   value="{{old('contact_no')?old('contact_no'):$data->contact_no}}"
                                                   name="contact_no">
                                            @error('contact_no')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="address">Supplier Address</label>
                                    <textarea id="address" rows="5"
                                              class="form-control @error('address') is-invalid @enderror" name="address"
                                              placeholder="Supplier Address">{{old('address')?old('address'):$data->address}}</textarea>
                                    @error('address')
                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                </div>

                                <div class="form-actions">
                                    <a type="button" href="{{ route('commercial.suppliers.index') }}"
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
    <script src="{{asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/js/scripts/forms/select/form-select2.js')}}" type="text/javascript"></script>
@endpush
