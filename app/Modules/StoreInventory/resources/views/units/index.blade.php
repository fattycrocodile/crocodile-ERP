@extends('layouts.app')
@section('title') {{ isset($pageTitle) ? $pageTitle : 'Categories' }} @endsection
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endpush
@section('content')
    <div class="row">
        <div class="col-12 text-right">
            <a type="button" class="btn btn-info btn-min-width mr-1 mb-1" href="{{route('storeInventory.units.create')}}"><i
                    class="fa fa-plus"></i> Add New</a>
        </div>
    </div>
    <!-- Basic Tables start -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Units list</h4>
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
                <div class="card-content collapse show">
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered file-export">
                                <thead>
                                <tr>
                                    <th>SL NO</th>
                                    <th>Unit Name</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($units as $k=>$unit)
                                    <tr>
                                        <th>{{$k+1}}</th>
                                        <td>{{$unit->name}}</td>
                                        <td>{{$unit->description}}</td>
                                        <td><a class="btn btn-primary" href="{{route('storeInventory.units.edit',$unit->id)}}">Edit</a> </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
@endsection
@push('scripts')
                        <script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.min.js')}}" type="text/javascript"></script>
                        <script src="{{asset('app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js')}}"
                                type="text/javascript"></script>
                        <script src="{{asset('app-assets/vendors/js/tables/buttons.flash.min.js')}}" type="text/javascript"></script>
                        <script src="{{asset('app-assets/vendors/js/tables/jszip.min.js')}}" type="text/javascript"></script>
                        <script src="{{asset('app-assets/vendors/js/tables/pdfmake.min.js')}}" type="text/javascript"></script>
                        <script src="{{asset('app-assets/vendors/js/tables/vfs_fonts.js')}}" type="text/javascript"></script>
                        <script src="{{asset('app-assets/vendors/js/tables/buttons.html5.min.js')}}" type="text/javascript"></script>
                        <script src="{{asset('app-assets/vendors/js/tables/buttons.print.min.js')}}" type="text/javascript"></script>
                        <script src="{{asset('app-assets/js/scripts/tables/datatables/datatable-advanced.js')}}"
                                type="text/javascript"></script>
@endpush
