@extends('layouts.app')

@section('pageTitle', __('Employees'))

@section('content')

<div class="container">

    <div class="row mb-3"><div class="col h5"><i class="bi bi-people-fill"></i> {{ __('Employees') }}</div></div>

    @livewire('employee.index')
</div>

@endsection
