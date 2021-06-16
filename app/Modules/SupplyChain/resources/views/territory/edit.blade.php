@extends('layouts.app')
@section('title') {{ $pageTitle }} @endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/selects/select2.min.css')}}">
@endpush

@section('content')
    @include('inc.flash')
    <section class="basic-elements">
        <div class="d-flex justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Update Territory</h4>
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
                                  action="{{route('supplyChain.territory.update',$targetterritory->id)}}">
                                @method('post')
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="parentCategory">Store</label>
                                                <select id="parentCategory" name="area_id"
                                                        class="select2 form-control @error('area_id') is-invalid @enderror">
                                                    <option value="none" selected="" disabled="">Select Area
                                                    </option>
                                                    @foreach($areas as $key => $store)
                                                        @if ($targetterritory->area_id == $store->id)
                                                            <option value="{{ $store->id }}"
                                                                    selected> {{ $store->name }} </option>
                                                        @else
                                                            <option
                                                                value="{{ $store->id }}"> {{ $store->name }} </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('area_id')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="areaName">Territory Name</label>
                                                <input type="text" id="areaName"
                                                       class="form-control @error('name') is-invalid @enderror"
                                                       placeholder="Territory Name"
                                                       name="name"
                                                       value="{{old('name')?old('name'):$targetterritory->name}}">
                                                @error('name')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="code">Code</label>
                                                <input type="text" id="code"
                                                       class="form-control @error('code') is-invalid @enderror"
                                                       placeholder="Territory Code"
                                                       value="{{old('code')?old('code'):$targetterritory->code}}"
                                                       name="code">
                                                @error('code')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="contact_no">Contact No</label>
                                                <input type="text" id="contact_no"
                                                       class="form-control @error('contact_no') is-invalid @enderror"
                                                       placeholder="Contact"
                                                       value="{{old('contact_no')?old('contact_no'):$targetterritory->contact_no}}"
                                                       name="contact_no">
                                                @error('contact_no')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="employee_id">TSO</label>
                                                <select id="employee_id" name="employee_id"
                                                        class="select2 form-control @error('employee_id') is-invalid @enderror">
                                                    <option value="none" selected="" disabled="">Select TSO
                                                    </option>
                                                    @foreach($employees as $key => $emp)
                                                        @if ($targetterritory->employee_id == $emp->id)
                                                            <option value="{{ $emp->id }}"
                                                                    selected> {{ $emp->full_name }} </option>
                                                        @else
                                                            <option
                                                                value="{{ $emp->id }}"> {{ $emp->full_name }} </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('employee_id')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="address">Address</label>
                                                <textarea name="address" id="address" cols="50" rows="10"
                                                          class="form-control @error('address') is-invalid @enderror">{{old('address')?old('address'):$targetterritory->address}}</textarea>
                                                @error('address')
                                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <a type="button" href="{{ route('supplyChain.territory.index') }}"
                                           class="btn btn-warning mr-1">
                                            <i class="ft-x"></i> Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-check-square-o"></i> Update
                                        </button>
                                    </div>
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
    <script src="{{asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/js/scripts/forms/select/form-select2.js')}}" type="text/javascript"></script>
@endpush
