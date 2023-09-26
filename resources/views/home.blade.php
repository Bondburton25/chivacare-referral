@extends('layouts.app')

@section('pageTitle', __('Homepage'))

@section('content')

<div class="container">
    <div class="row mb-3">
        <div class="col h5"><i class="bi bi-people-fill"></i> {{ __('List of all referred patients') }}</div>
        @cannot('isAdmin')
        <div class="col text-end"><a href="{{ route('patients.create') }}" class="btn btn-sm btn-primary">{{ __('Refer the patient') }} <i class="bi bi-person-badge-fill"></i></a></div>
        @endcannot
    </div>
    @livewire('patient.index')
</div>

@endsection
