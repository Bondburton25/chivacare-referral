@extends('layouts.app')

@section('pageTitle', __('Refer the patient'))

@section('content')

<div class="container">

    <h1 class="h5 mb-3">Patient profile</h1>

    <div class="row">
        <div class="col-md-3 col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    {{ __('Patient infomation') }}
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            {{ __('First Name') }}
                            <span>{{ $patient->first_name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            {{ __('Last Name') }}
                            <span>{{ $patient->last_name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            {{ __('Gender') }}
                            <span>{{ __($patient->gender) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            {{ __('Birth date') }}
                            <span>{{ $patient->birth_date }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            {{ __('Age') }}
                            <span>{{ $patient->age() }} {{ __('Years') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            {{ __('Weight') }}
                            <span>{{ $patient->weight }} {{ __('kg') }}.</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            {{ __('Height') }}
                            <span>{{ $patient->height }} {{ __('cm') }}.</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            {{ __('Congenital disease') }}
                            <span>{{ __($patient->congenital_disease) }}</span>
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
                            <span>{{ $patient->current_symptoms }}</span>
                        </li>
                        <li class="list-group-item align-items-center border-0 px-0">
                            {{ __('อาหารที่รับประทาน') }}:
                            <span>{{ $patient->food }}</span>
                        </li>
                        <li class="list-group-item align-items-center border-0 px-0">
                            {{ __('ระบบขับถ่าย') }}:
                            <span>{{ $patient->food }}</span>
                        </li>
                        <li class="list-group-item align-items-center border-0 px-0">
                            {{ __('ความคาดหวังญาติ') }}:
                            <span>{{ $patient->expectations }}</span>
                        </li>
                        <li class="list-group-item align-items-center border-0 px-0">
                            {{ __('ญาติผู้ติดต่อ') }}:
                            <span>{{ $patient->contact_person }}</span>
                        </li>
                        <li class="list-group-item align-items-center border-0 px-0">
                            {{ __('ความสัมพันธ์') }}:
                            <span>{{ $patient->contact_person_relationship }}</span>
                        </li>
                        <li class="list-group-item align-items-center border-0 px-0">
                            {{ __('Phone number') }}:
                            <span>{{ $patient->phone_number }}</span>
                        </li>
                        <li class="list-group-item align-items-center border-0 px-0">
                            {{ __('วันเวลาคาดการณ์ที่จะเข้าพัก') }}:
                            <span>{{ $patient->arrival_date_time_expectation }}</span>
                        </li>
                        <li class="list-group-item align-items-center border-0 px-0">
                            {{ __('ประเภทห้อง') }}:
                            <span>{{ __($patient->room_type) }}</span>
                        </li>
                        <li class="list-group-item align-items-center border-0 px-0">
                            {{ __('Courses') }}:
                            <span>{{ $patient->offer_courses }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
