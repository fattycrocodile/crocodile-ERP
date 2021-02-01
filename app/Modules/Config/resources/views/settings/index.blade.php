@extends('layouts.app')
@section('title') {{ $pageTitle }} @endsection


@section('content')

    @include('inc.flash')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title"><i class="fa fa-cogs"></i> {{ $pageTitle }}</h5>
                    </div>
                    <div class="list-group list-group-flush" role="tablist">
                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#general"
                           role="tab">General</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#site-logo"
                           role="tab">Logo</a>
                    </div>
                </div>
            </div>

            <div class="col-md-9 ">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="general" role="tabpanel">
                        @include('Config::settings.includes.general')
                    </div>
                    <div class="tab-pane fade" id="site-logo" role="tabpanel">
                        @include('Config::settings.includes.logo')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
