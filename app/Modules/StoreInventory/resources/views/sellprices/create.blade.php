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
                        <h4 class="card-title">Add New Price</h4>
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
                            <form class="form" method="post" action="{{route('storeInventory.sellprices.store')}}"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="product_name">Product Name</label>
                                        <input type="text"
                                               class="form-control @error('product_id') is-invalid @enderror"
                                               id="product_name" name="product_name">
                                        <input type="hidden" name="product_id" id="product_id">
                                        @error('product_id')
                                        <div class="help-block text-danger">{{ $message }} </div> @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sell_price">Sell Price <span
                                                    class="required text-danger">*</span></label>
                                            <input type="text" id="sell_price"
                                                   class="form-control @error('sell_price') is-invalid @enderror"
                                                   placeholder="Sell Price" value="{{ old('sell_price') }}"
                                                   name="sell_price">
                                            @error('sell_price')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="whole_sell_price">Wholesale Price</label>
                                            <input type="text" id="whole_sell_price"
                                                   class="form-control @error('whole_sell_price') is-invalid @enderror"
                                                   placeholder="Wholesale Price" value="{{ old('whole_sell_price') }}"
                                                   name="whole_sell_price">
                                            @error('whole_sell_price')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="min_sell_price">Min Sell Price</label>
                                            <input type="text" id="min_sell_price"
                                                   class="form-control @error('min_sell_price') is-invalid @enderror"
                                                   placeholder="Min Sell Price" value="{{ old('min_sell_price') }}"
                                                   name="min_sell_price">
                                            @error('min_sell_price')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="min_whole_sell_price">Min Wholesale Price<span
                                                    class="required text-danger">*</span></label>
                                            <input type="text" id="min_whole_sell_price"
                                                   class="form-control @error('min_whole_sell_price') is-invalid @enderror"
                                                   placeholder="Min Wholesale Price"
                                                   value="{{ old('min_whole_sell_price') }}"
                                                   name="min_whole_sell_price">
                                            @error('min_whole_sell_price')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="form-actions">
                                    <a type="button" href="{{ route('storeInventory.sellprices.index') }}"
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
    </section>
@endsection

@push('scripts')

    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $("#product_name").autocomplete({
            minLength: 1,
            autoFocus: true,
            source: function (request, response) {
                $.ajax({
                    url: "{{ route('productNameAutoComplete') }}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        search: request.term,
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            focus: function (event, ui) {
                return false;
            },
            select: function (event, ui) {
                if (ui.item.value != '' || ui.item.value > 0) {
                    getProductPrice(ui.item.value);
                    $('#product_name').val(ui.item.name);
                    $('#product_id').val(ui.item.value);
                } else {
                    resetProduct();
                }
                return false;
            },
        }).data("ui-autocomplete")._renderItem = function (ul, item) {

            var inner_html = '<div>' + item.label + ' (<i>' + item.code + ')</i></div>';
            return $("<li>")
                .data("item.autocomplete", item)
                .append(inner_html)
                .appendTo(ul);
        };

        function getProductPrice(product_id) {
            $.ajax({
                url: "{{ route('productPrice') }}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    search: product_id,
                },
                success: function (data) {
                    $("#sell_price").val(data.sell_price);
                    $("#min_sell_price").val(data.min_sell_price);
                    $("#whole_sell_price").val(data.whole_sell_price);
                    $("#min_whole_sell_price").val(data.min_whole_sell_price);
                },
                error: function (xhr, status, error) {
                    $("#sell_price").val(0);
                    $("#min_sell_price").val(0);
                    $("#whole_sell_price").val(0);
                    $("#min_whole_sell_price").val(0);
                }
            }).done(function (data) {
                $("#sell_price").val(data.sell_price);
                $("#min_sell_price").val(data.min_sell_price);
                $("#whole_sell_price").val(data.whole_sell_price);
                $("#min_whole_sell_price").val(data.min_whole_sell_price);
            }).fail(function (jqXHR, textStatus) {
                $("#sell_price").val(0);
                $("#min_sell_price").val(0);
                $("#whole_sell_price").val(0);
                $("#min_whole_sell_price").val(0);
            });
        }

        function resetProduct() {
            $('#product_code').val("");
            $('#product_id').val("");
            $('#product_name').val("");
        }
    </script>
@endpush
