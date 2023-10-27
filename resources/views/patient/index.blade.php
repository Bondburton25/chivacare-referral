@extends('layouts.app')

@section('pageTitle', __('Homepage'))

@section('content')

<div class="container">

    <div class="d-flex justify-content-between mb-3">
        <div class="page-title h5 text-success mb-0 align-self-center">รายการผู้ป่วยทั้งหมด</div>
        test
        @cannot('isAdmin')
        <div><a href="{{ route('patients.create') }}" class="btn btn-primary">{{ __('Refer the patient') }} <i class="bi bi-person-badge-fill"></i></a></div>
        @endcannot
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-sm align-middle caption-top">
            <caption class="text-muted">
                <small>ค้นพบทั้งหมด {{ $patients->count() }} ท่าน</small>
            </caption>
            <tbody>
                <tr>
                    <td>HN Hosptial</td>
                    <td>Name</td>
                    <td>Action</td>
                </tr>
                @foreach ($patients as $patient)
                <tr>
                    <td>{{ $patient->number }}</td>
                    <td>{{ $patient->full_name }}</td>
                    <td><a class="btn btn-primary btn-sm" href="{{ route('patients.show',$patient->id) }}">ดูข้อมูล</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
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
