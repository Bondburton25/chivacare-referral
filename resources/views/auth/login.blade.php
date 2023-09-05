@extends('layouts.app')

@section('pageTitle', __('Login'))

@section('stylesheet')

<style>
    .btn-line {
        background: #06C755!important;
        color: #FFF!important;
        background-color: #00B900;
        border-color: #00B900;
        border: 0;
        transition: 0.8s;
    }
    .btn-line:hover {
        background-color: #009300;
    }
</style>

@endsection

@section('content')

<div class="container">

    {{url()->current()}}

    <div class="row row-cols-1 row-cols-md-2 g-4 justify-content-center">
        <div class="col-12 col-sm-5 col-lg-3">
            <div class="card h-100 shadow-sm border-0">
                <a href="{{ url('auth/line') }}">
                    <img src="{{ asset('images/close-up-male-hands-using-smartphone.jpg') }}" class="card-img-top" alt="{{ __('Log in or register with your LINE account') }}">
                </a>
                <div class="card-body">
                    <p class="card-text text-muted mb-3">{{ __('Log in or register with your LINE account') }}</p>
                    <div class="d-grid gap-2">
                        <a href="{{ url('auth/line') }}" class="btn btn-line" title="{{ __('Log in with LINE account') }}">{{ __('Log in with LINE account') }} <i class="bi bi-line"></i></a>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>

@endsection
