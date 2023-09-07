@extends('layouts.app')

@section('pageTitle', __('Homepage'))

@section('content')

<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <div class="page-title h5 text-success mb-0 align-self-center"><i class="bi bi-people-fill"></i> {{ __('List of all referred patients') }}</div>
        <div class="button-action"><a href="{{ route('patients.create') }}" class="btn btn-sm btn-primary">{{ __('Refer the patient') }} <i class="bi bi-person-badge-fill"></i></a></div>
    </div>
    @livewire('patient.index')
</div>

@endsection
