@extends('layouts.app')
@section('title') {{ isset($pageTitle) ? $pageTitle : 'Server Error!' }} @endsection
@section('content')

    <div class="content-body">
        <section class="flexbox-container">
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div class="col-md-4 col-10 p-0">
                    <div class="card-header bg-transparent border-0">
                        <h2 class="error-code text-center mb-2">500</h2>
                        <h3 class="text-uppercase text-center">Internal Server Error</h3>
                    </div>
                    <div class="card-content">

                        <div class="row py-2">

                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
{{--                        <div class="row">--}}
{{--                            <p class="text-muted text-center col-12 py-1">© 2016 <a href="#">Stack </a>Crafted with <i class="ft-heart pink"> </i>                    by <a href="http://themeforest.net/user/pixinvent/portfolio"--}}
{{--                                                                                                                                                                            target="_blank">PIXINVENT</a></p>--}}
{{--                            <div class="col-12 text-center">--}}
{{--                                <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-facebook">--}}
{{--                                    <span class="fa fa-facebook"></span>--}}
{{--                                </a>--}}
{{--                                <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-twitter">--}}
{{--                                    <span class="fa fa-twitter"></span>--}}
{{--                                </a>--}}
{{--                                <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-linkedin">--}}
{{--                                    <span class="fa fa-linkedin font-medium-4"></span>--}}
{{--                                </a>--}}
{{--                                <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-github">--}}
{{--                                    <span class="fa fa-github font-medium-4"></span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
