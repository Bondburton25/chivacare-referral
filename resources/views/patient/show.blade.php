@extends('layouts.app')

@section('pageTitle', __('Patient profile').' '.$patient->full_name)

@section('content')

<div class="container">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a class="link-underline-light" href="{{ route('home') }}">{{ __('List of all referred patients') }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ __('Patient profile') }} {{ $patient->fullname }}</li>
        </ol>
    </nav>

    <div class="row mb-3">
        <div class="col h5"><i class="bi bi-user-fill"></i> {{ __('Patient profile') }}</div>
        {{-- <div class="col text-end"><a href="{{ route('patients.create') }}" class="btn btn-sm btn-primary">{{ __('Refer the patient') }} <i class="bi bi-person-badge-fill"></i></a></div> --}}
    </div>

    <div class="row">
        <div class="col-md-3 col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header">{{ __('Patient information') }}</div>
                <div class="card-body">

                    @if($patient->avatar)
                    <div class="mx-auto w-50 mb-5 text-center">
                        <img src="{{ url('images/patients/avatars/'.$patient->avatar) }}" width="120px" height="120px" class="rounded-circle border border-2">
                    </div>
                    @endif

                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 ">
                            {{ __('First Name') }}
                            <span class="text-success">{{ $patient->first_name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            {{ __('Last Name') }}
                            <span class="text-success">{{ $patient->last_name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            {{ __('Gender') }}
                            <span class="text-success">{{ __($patient->gender) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            {{ __('Birth date') }}
                            <span class="text-success">{{ $patient->birth_date }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            {{ __('Age') }}
                            <span class="text-success">{{ $patient->age() }} {{ __('Years') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            {{ __('Weight') }}
                            <span class="text-success">{{ $patient->weight }} {{ __('kg') }}.</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            {{ __('Height') }}
                            <span class="text-success">{{ $patient->height }} {{ __('cm') }}.</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            {{ __('Congenital disease') }}
                            <span class="text-success">{{ __($patient->congenital_disease) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    {{ __('History of treatment') }}
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item align-items-center border-0 px-0 mb-0">
                            {{ __('อาารปัจจุปัน') }}:
                            <span class="text-success">{{ $patient->current_symptoms }}</span>
                        </li>
                        <li class="list-group-item align-items-center border-0 px-0">
                            {{ __('อาหารที่รับประทาน') }}:
                            <span class="text-success">{{ $patient->food }}</span>
                        </li>
                        <li class="list-group-item align-items-center border-0 px-0">
                            {{ __('ระบบขับถ่าย') }}:
                            <span class="text-success">{{ $patient->excretory_system }}</span>
                        </li>
                        <li class="list-group-item align-items-center border-0 px-0">
                            {{ __('ความคาดหวังญาติ') }}:
                            <span class="text-success">{{ $patient->expectations }}</span>
                        </li>
                        <li class="list-group-item align-items-center border-0 px-0">
                            {{ __('ญาติผู้ติดต่อ') }}:
                            <span class="text-success">{{ $patient->contact_person }}</span>
                        </li>
                        <li class="list-group-item align-items-center border-0 px-0">
                            {{ __('ความสัมพันธ์') }}:
                            <span class="text-success">{{ $patient->contact_person_relationship }}</span>
                        </li>
                        <li class="list-group-item align-items-center border-0 px-0">
                            {{ __('Phone number') }}:
                            <span class="text-success">{{ $patient->phone_number }}</span>
                        </li>
                        <li class="list-group-item align-items-center border-0 px-0">
                            {{ __('วันเวลาคาดการณ์ที่จะเข้าพัก') }}:
                            <span class="text-success">{{ $patient->arrival_date_time_expectation }}</span>
                        </li>
                        <li class="list-group-item align-items-center border-0 px-0">
                            {{ __('ประเภทห้อง') }}:
                            <span class="text-success">{{ __($patient->room_type) }}</span>
                        </li>
                        <li class="list-group-item align-items-center border-0 px-0">
                            {{ __('Courses') }}:
                            <span class="text-success">{{ $patient->offer_courses }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
