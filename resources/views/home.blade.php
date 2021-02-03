@extends('layouts.app')
@section('title') {{ isset($pageTitle) ? $pageTitle : 'Dashboard' }} @endsection
@section('content')
    @include('dashboard')
@endsection
