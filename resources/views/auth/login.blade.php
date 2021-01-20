@extends('layouts.public')

@section('content')
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-md-4 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 m-0">
                                <div class="card-header border-0">
                                    <div class="card-title text-center">
                                        <div class="p-1">
                                            <img src="{{ asset('app-assets/images/logo/stack-logo-dark.png') }}"
                                                 alt="branding logo">
                                        </div>
                                    </div>
                                    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                                        <span>Easily Using</span>
                                    </h6>
                                </div>
                                <div class="card-content">
                                    <div class="card-body pt-0">
                                        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <fieldset class="form-group floating-label-form-group">
                                                <label for="user-name">{{ __('E-Mail Address') }}</label>
                                                <input id="email" placeholder="Your Email" type="email"
                                                       class="form-control @error('email') is-invalid @enderror"
                                                       name="email" value="{{ old('email') }}" required
                                                       autocomplete="email" autofocus>
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </fieldset>
                                            <fieldset class="form-group floating-label-form-group mb-1">
                                                <label for="user-password">{{ __('Password') }}</label>
                                                <input id="password" type="password"
                                                       class="form-control @error('password') is-invalid @enderror"
                                                       name="password" required autocomplete="current-password"
                                                       placeholder="Enter Password">
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </fieldset>
                                            <div class="form-group row">
                                                <div class="col-md-6 col-12 text-center text-sm-left">
                                                    <fieldset>
                                                        <input class="chk-remember" type="checkbox" name="remember"
                                                               id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                        <label for="remember-me"> {{ __('Remember Me') }}</label>
                                                    </fieldset>
                                                </div>

                                                @if (Route::has('password.request'))
                                                    <div
                                                        class="col-md-6 col-12 float-sm-left text-center text-sm-right">
                                                        <a
                                                            href="{{ route('password.request') }}"
                                                            class="card-link">{{ __('Forgot Your Password?') }}</a>
                                                    </div>
                                                @endif
                                            </div>
                                            <button type="submit" class="btn btn-outline-primary btn-block"><i
                                                    class="ft-unlock"></i> {{ __('Login') }}
                                            </button>
                                        </form>
                                    </div>
{{--                                    <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">--}}
{{--                                        <span>New to Stack ?</span>--}}
{{--                                    </p>--}}
{{--                                    @if (Route::has('register'))--}}
{{--                                        <div class="card-body">--}}
{{--                                            <a href="{{ route('register') }}" class="btn btn-outline-danger btn-block"><i--}}
{{--                                                    class="ft-user"></i> {{ __('Register') }}</a>--}}
{{--                                        </div>--}}
{{--                                    @endif--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->
@endsection
