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
                        <form class="form" method="post" action="{{route('crm.customers.store')}}">
                            @csrf
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="customerName" class="sr-only">Customer Name</label>
                                    <input type="text" id="customerName" class="form-control"
                                           placeholder="Customer Name"
                                           name="name">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="customerContact" class="sr-only">Customer Contact</label>
                                            <input type="text" id="customerContact" class="form-control"
                                                   placeholder="Customer Contact"
                                                   name="contact_no">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="store" class="sr-only">Store</label>
                                            <select id="store" name="store_id" class="select2 form-control">
                                                <option value="none" selected="" disabled="">Select Store</option>
                                                @foreach($stores as $store)
                                                    <option value="{{$store->id}}">{{$store->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="address" class="sr-only">Customer Address</label>
                                    <textarea id="address" rows="5" class="form-control" name="address"
                                              placeholder="Customer Address"></textarea>
                                </div>

                                <div class="form-actions">
                                    <button type="button" class="btn btn-outline-warning mr-1">
                                        <i class="ft-x"></i> Cancel
                                    </button>
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="ft-check"></i> Save
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
