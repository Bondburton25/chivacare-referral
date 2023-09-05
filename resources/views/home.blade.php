@extends('layouts.app')

@section('pageTitle', __('Homepage'))

@section('content')

<div class="container">


    {{ env('LINE_CLIENT_ID') }} <br>

    <div class="d-flex justify-content-end">
        <a href="{{ route('patients.create') }}" class="btn btn-primary">{{ __('Refer the patient') }} <i class="bi bi-person-badge-fill"></i></a>
    </div>

    {{-- <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div> --}}
</div>
@endsection
