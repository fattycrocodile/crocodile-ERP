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
                    <h4 class="card-title">Edit a Store</h4>
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
                        <form class="form" method="post" action="{{route('storeInventory.stores.update',$store->id)}}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="StoreName">Store Name <span class="required text-danger">*</span></label>
                                    <input type="text" id="StoreName"
                                           class="form-control @error('name') is-invalid @enderror"
                                           placeholder="Store Name" value="{{ old('name')?old('name'):$store->name }}"
                                           name="name">
                                    @error('name')
                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact">Phone No <span class="required text-danger">*</span></label>
                                            <input type="text" id="contact"
                                                   class="form-control @error('contact') is-invalid @enderror"
                                                   placeholder="Phone No" value="{{ old('contact')?old('contact'):$store->contact }}"
                                                   name="contact">
                                            @error('contact')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="StoreCode">Store Code <span class="required text-danger">*</span></label>
                                            <input type="text" id="StoreCode"
                                                   class="form-control @error('code') is-invalid @enderror"
                                                   placeholder="Store code" value="{{ old('code')?old('code'):$store->code }}"
                                                   name="code">
                                            @error('code')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pad_header">Store Pad Header</label>
                                            <input type="file" id="pad_header" class="form-control @error('pad_header') is-invalid @enderror"
                                                   placeholder="Store Pad Header"
                                                   name="pad_header"
                                                   onchange="document.getElementById('pad_header_view').src = window.URL.createObjectURL(this.files[0])">
                                            @error('pad_header')<div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <img id="pad_header_view" src="{{asset($store->pad_header)}}" alt="" width="100">
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pad_footer">Store Pad Footer</label>
                                            <input type="file" id="pad_footer" class="form-control @error('pad_footer') is-invalid @enderror"
                                                   placeholder="Store Pad Footer"
                                                   name="pad_footer"
                                                   onchange="document.getElementById('pad_footer_view').src = window.URL.createObjectURL(this.files[0])">
                                            @error('pad_footer')<div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <img id="pad_footer_view" src="{{asset($store->pad_footer)}}" alt="" width="100">
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pad">Store Pad</label>
                                            <input type="file" id="pad" class="form-control @error('pad') is-invalid @enderror"
                                                   placeholder="Category Image"
                                                   name="pad"
                                                   onchange="document.getElementById('pad_view').src = window.URL.createObjectURL(this.files[0])">
                                            @error('pad')<div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <img id="pad_view" src="{{asset($store->pad)}}" alt="" width="100">
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label for="address">Address <span class="required text-danger">*</span></label>
                                    <textarea name="address" id="address" cols="50" rows="20"
                                              class="form-control @error('address') is-invalid @enderror">{{old('address')?old('address'):$store->address}}</textarea>
                                    @error('address')
                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                </div>


                                <div class="form-actions">
                                    <a type="button" href="{{ route('storeInventory.stores.index') }}"
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
    <script src="{{asset('assets/ckeditor/ckeditor.js')}}" type="text/javascript"></script>

    <script>
        $(function () {
            // instance, using default configuration.
            CKEDITOR.replace('address')
        })
    </script>
@endpush
