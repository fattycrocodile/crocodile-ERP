@extends('layouts.app')
@section('title') {{ $pageTitle }} @endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/selects/select2.min.css')}}">
@endpush

@section('content')
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
                        <form class="form" method="post" action="{{route('storeInventory.categories.update',$targetCategory->id)}}"
                              enctype="multipart/form-data">
                            @method('post')
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="categoryName" class="sr-only">Category Name</label>
                                            <input type="text" id="categoryName" class="form-control"
                                                   placeholder="Category Name"
                                                   name="name" value="{{$targetCategory->name}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="parentCategory" class="sr-only">Store</label>
                                            <select id="parentCategory" name="root_id" class="select2 form-control">
                                                <option value="none" selected="" disabled="">Select Parent Category
                                                </option>
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}" {{$category->id==$targetCategory->root_id?'selected':''}}>{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="image" class="sr-only">Category Image</label>
                                            <input type="file" id="image" class="form-control"
                                                   placeholder="Category Image"
                                                   name="image"
                                                   onchange="document.getElementById('imageview').src = window.URL.createObjectURL(this.files[0])">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <img id="imageview" src="{{asset($targetCategory->image)}}" alt="" width="100">
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="button" class="btn btn-outline-warning mr-1">
                                        <i class="ft-x"></i> Cancel
                                    </button>
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="ft-check"></i> Update
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
