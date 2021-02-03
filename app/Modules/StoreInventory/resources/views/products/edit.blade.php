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
                    <h4 class="card-title">Create New Product</h4>
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
                        <form class="form" method="post" action="{{route('storeInventory.products.update',$product->id)}}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="productName">Product Name <span class="required text-danger">*</span></label>
                                    <input type="text" id="productName"
                                           class="form-control @error('name') is-invalid @enderror"
                                           placeholder="Product Name" value="{{ old('name')?old('name'):$product->name }}"
                                           name="name">
                                    @error('name')
                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category">Category <span class="required text-danger">*</span></label>
                                            <select id="category" name="category_id"
                                                    class="select2 form-control @error('category_id') is-invalid @enderror">
                                                <option value="none" selected="" disabled="">Select Category
                                                </option>
                                                @foreach($categories as $category)
                                                    <option
                                                        value="{{$category->id}}" {{ (old('category_id')?old('category_id'):$product->category_id)==$category->id?'selected':'' }}>{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="brand">Brand <span class="required text-danger">*</span></label>
                                            <select id="brand" name="brand_id"
                                                    class="select2 form-control @error('brand_id') is-invalid @enderror">
                                                <option value="none" selected="" disabled="">Select Brand
                                                </option>
                                                @foreach($brands as $brand)
                                                    <option
                                                        value="{{$brand->id}}" {{ (old('brand_id')?old('brand_id'):$product->brand_id)==$brand->id?'selected':'' }}>{{$brand->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('brand_id')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="unit">Unit <span class="required text-danger">*</span></label>
                                            <select id="unit" name="unit_id"
                                                    class="select2 form-control @error('unit_id') is-invalid @enderror">
                                                <option value="none" selected="" disabled="">Select Unit
                                                </option>
                                                @foreach($units as $unit)
                                                    <option
                                                        value="{{$unit->id}}" {{ (old('unit_id')?old('unit_id'):$product->unit_id)==$unit->id?'selected':'' }}>{{$unit->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('unit_id')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="productCode">Product Code <span class="required text-danger">*</span></label>
                                            <input type="text" id="productCode"
                                                   class="form-control @error('code') is-invalid @enderror"
                                                   placeholder="Product code" value="{{ old('code')?old('code'):$product->code }}"
                                                   name="code">
                                            @error('code')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="stockQty">Minimum Stock Qty <span class="required text-danger">*</span></label>
                                            <input type="text" id="stockQty"
                                                   class="form-control @error('min_stock_qty') is-invalid @enderror"
                                                   placeholder="Minimum Order Qty" value="{{ old('min_stock_qty')?old('min_stock_qty'):$product->min_stock_qty }}"
                                                   name="min_stock_qty">
                                            @error('min_stock_qty')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="orderQty">Minimum Order Qty <span class="required text-danger">*</span></label>
                                            <input type="text" id="orderQty"
                                                   class="form-control @error('min_order_qty') is-invalid @enderror"
                                                   placeholder="Minimum Order Qty" value="{{ old('min_order_qty')?old('min_order_qty'):$product->min_order_qty }}"
                                                   name="min_order_qty">
                                            @error('min_order_qty')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sellPrice">Sell Price <span class="required text-danger">*</span></label>
                                            <input type="text" id="sellPrice"
                                                   class="form-control @error('sell_price') is-invalid @enderror"
                                                   placeholder="Sell Price" value="{{ old('sell_price')?old('sell_price'):$sellPrice->sell_price }}"
                                                   name="sell_price">
                                            @error('sell_price')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="wholesalePrice">Wholesale Price <span class="required text-danger">*</span></label>
                                            <input type="text" id="wholesalePrice"
                                                   class="form-control @error('whole_sell_price') is-invalid @enderror"
                                                   placeholder="Wholesale Price" value="{{ old('whole_sell_price')?old('whole_sell_price'):$sellPrice->whole_sell_price }}"
                                                   name="whole_sell_price">
                                            @error('whole_sell_price')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="minsellPrice">Min Sell Price</label>
                                            <input type="text" id="minsellPrice"
                                                   class="form-control @error('min_sell_price') is-invalid @enderror"
                                                   placeholder="Min Sell Price" value="{{ old('min_sell_price')?old('min_sell_price'):$sellPrice->min_sell_price }}"
                                                   name="min_sell_price">
                                            @error('min_sell_price')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="minwholesalePrice">Min Wholesale Price</label>
                                            <input type="text" id="minwholesalePrice"
                                                   class="form-control @error('min_whole_sell_price') is-invalid @enderror"
                                                   placeholder="Min Wholesale Price" value="{{ old('min_whole_sell_price')?old('min_whole_sell_price'):$sellPrice->min_whole_sell_price }}"
                                                   name="min_whole_sell_price">
                                            @error('min_whole_sell_price')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="desc">Description <span class="required text-danger">*</span></label>
                                    <textarea name="description" id="desc" cols="50" rows="20"
                                              class="form-control @error('description') is-invalid @enderror">{{old('description')?old('description'):$product->description}}</textarea>
                                    @error('description')
                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                </div>


                                <div class="form-actions">
                                    <a type="button" href="{{ route('storeInventory.categories.index') }}"
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
    <script src="{{asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/js/scripts/forms/select/form-select2.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/ckeditor/ckeditor.js')}}" type="text/javascript"></script>

    <script>
        $(function () {
            // instance, using default configuration.
            CKEDITOR.replace('desc')
        })
    </script>
@endpush
