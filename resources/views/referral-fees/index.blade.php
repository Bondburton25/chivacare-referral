@extends('layouts.app')

@section('pageTitle', __('Patient referral fees'))

@section('content')

<div class="container">
    <div class="row mb-3">
        <div class="col h5"><i class="bi bi-people-fill"></i> {{ __('Patient referral fees') }}</div>
    </div>
    @livewire('referral-fee.index')
</div>

@endsection
