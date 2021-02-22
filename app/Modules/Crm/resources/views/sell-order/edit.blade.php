@extends('layouts.app')
@section('title') {{ $pageTitle }} @endsection


@section('content')

    @include('inc.flash')
    <div class="d-flex justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Update Brand</h4>
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
                        <form class="form" method="post" action="{{route('storeInventory.brands.update')}}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <fieldset class="form-group">
                                    <label for="placeTextarea">Brand Name<span
                                            class="required text-danger">*</span></label>
                                    <input type="text" id="name"
                                           class="form-control  @error('name') is-invalid @enderror"
                                           placeholder="Brand Name"
                                           name="name" value="{!! old('name', $brands->name)  !!}">
                                    <input type="hidden" name="id" value="{{ $brands->id }}">
                                    @error('name')
                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                </fieldset>
                                <fieldset class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control  @error('description') is-invalid @enderror"
                                              id="description"
                                              rows="3"
                                              placeholder="Description"
                                              name="description">{!! old('description', $brands->description)  !!}</textarea>
                                    @error('description')
                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                </fieldset>
                                <fieldset class="form-group">
                                    <label for="description">Logo</label>
                                    <input type="file" id="logo"
                                           class="form-control @error('logo') is-invalid @enderror"
                                           placeholder="Brand Logo"
                                           name="logo"
                                           onchange="document.getElementById('imageview').src = window.URL.createObjectURL(this.files[0])">

                                    @error('logo')
                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                    @if ($brands->logo != null)
                                        <figure class="mt-2" style="width: 80px; height: auto;">
                                            <img src="{{ asset('public/uploads/'.$brands->logo) }}" id="imageview"
                                                 class="img-fluid" alt="img">
                                        </figure>
                                    @else
                                        <img id="imageview"
                                             class="img-fluid" alt="img">
                                    @endif
                                </fieldset>
                                <div class="form-actions">
                                    <a type="button" href="{{ route('storeInventory.brands.index') }}"
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
