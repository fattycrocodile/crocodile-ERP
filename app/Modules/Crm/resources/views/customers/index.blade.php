@extends('layouts.app')
@section('title') {{ $pageTitle }} @endsection

@section('content')
    <div class="row">
        <div class="col-12 text-right">
            <a type="button" class="btn btn-info btn-min-width mr-1 mb-1" href="{{route('crm.customers.create')}}"><i
                    class="fa fa-plus"></i> Add New</a>
        </div>
    </div>
    <!-- Basic Tables start -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Customers list</h4>
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
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>SL NO</th>
                                    <th>Customer Name</th>
                                    <th>Customer Contact</th>
                                    <th>Customer Address</th>
                                    <th>Store</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($customers as $k=>$customer)
                                    <tr>
                                        <th>{{$k+1}}</th>
                                        <td>{{$customer->name}}</td>
                                        <td>{{$customer->contact_no}}</td>
                                        <td>{{$customer->address}}</td>
                                        <td>{{$customer->store->name}}</td>
                                        <td><a class="btn btn-primary" href="{{route('crm.customers.edit',$customer->id)}}">Edit</a> </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
@endsection
