@extends('layouts.app')

@section('pageTitle', __('Refer the patient'))

@section('content')

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-4 col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header fw-bold border-0">{{ __('Refer the patient') }}</div>
                <img src="{{ asset('images/close-up-male-hands-using-smartphone.jpg') }}" class="border-0 link-opacity-10-hover" alt="">
                <div class="card-body py-4">

                    <form method="POST" action="{{ route('patients.store') }}">
                    @csrf

                        <span class="fw-bold">{{ __('Patient information') }}</span>

                        <div class="row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control form-control-sm @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" autocomplete="first_name" autofocus>
                                @error('first_name')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control form-control-sm @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" autocomplete="last_name" autofocus>
                                @error('last_name')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <label for="phone_number" class="col-md-4 col-form-label text-md-end">{{ __('Phone number') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="phone_number" type="text" class="form-control form-control-sm @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="phone_number" autofocus>
                                @error('phone_number')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <label for="birth_date" class="col-md-4 col-form-label text-md-end">{{ __('Birth date') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="birth_date" type="date" class="form-control form-control-sm @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date') }}" required autocomplete="birth_date" autofocus>
                                @error('birth_date')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <label for="gender" class="col-md-4 col-form-label text-md-end">{{ __('Gender') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <select name="gender" id="gender" class="form-control form-control-sm @error('gender') is-invalid @enderror">
                                    <option value="" selected>{{ __('Please select') }}</option>
                                    <option value="male">{{ __('Male') }}</option>
                                    <option value="female">{{ __('Female') }}</option>
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <label for="weight" class="col-md-4 col-form-label text-md-end">{{ __('Weight') }}</label>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control form-control-sm" id="weight" name="weight">
                                    <span class="input-group-text" id="weight_label">{{ __('kg') }}.</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="height" class="col-md-4 col-form-label text-md-end">{{ __('Height') }}</label>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control form-control-sm" id="height" name="height">
                                    <span class="input-group-text" id="weight_label">{{ __('kg') }}.</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="congenital_disease" class="col-md-4 col-form-label text-md-end">{{ __('โรคประจำตัว') }}</label>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control form-control-sm" id="congenital_disease" name="congenital_disease">
                                </div>
                            </div>
                        </div>

                        <span class="fw-bold">ประวัติการรักษา</span>

                        <div class="row">
                            <label for="current_symptoms" class="col-md-4 col-form-label text-md-end">{{ __('อาการปัจจุปัน') }}</label>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control form-control-sm" id="current_symptoms" name="current_symptoms">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="food" class="col-md-4 col-form-label text-md-end">{{ __('อาหารที่รับประทาน') }}</label>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control form-control-sm" id="food" name="food">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="excretory_system" class="col-md-4 col-form-label text-md-end">{{ __('ระบบขับถ่าย') }}</label>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control form-control-sm" id="excretory_system" name="excretory_system">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="expectations" class="col-md-4 col-form-label text-md-end">{{ __('ความคาดหวังญาติ') }}</label>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control form-control-sm" id="expectations" name="expectations">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="contact_person" class="col-md-4 col-form-label text-md-end">{{ __('ญาติผู้ติดต่อ') }}</label>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control form-control-sm" id="contact_person" name="contact_person">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="contact_person_relationship" class="col-md-4 col-form-label text-md-end">{{ __('ความสัมพันธ์') }}</label>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control form-control-sm" id="contact_person_relationship" name="contact_person_relationship">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="phone_number" class="col-md-4 col-form-label text-md-end">{{ __('Phone number') }}</label>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control form-control-sm" id="phone_number" name="phone_number">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="arrival_date_time_expectation" class="col-md-4 col-form-label text-md-end">{{ __('วันเวลาคาดการณ์ที่จะเข้าพัก') }}</label>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <input type="datetime-local" id="arrival_date_time_expectation" class="form-control form-control-sm" name="arrival_date_time_expectation">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="room_type" class="col-md-4 col-form-label text-md-end">{{ __('ประเภทห้อง') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <select name="room_type" id="room_type" class="form-control form-control-sm @error('room_type') is-invalid @enderror">
                                    <option value="" selected>{{ __('Please select') }}</option>
                                    <option value="single">{{ __('ห้องเดี่ยว') }}</option>
                                    <option value="sharing">{{ __('ห้องรวม') }}</option>
                                </select>
                                @error('room_type')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <label for="offer_courses" class="col-md-4 col-form-label text-md-end">{{ __('Courses') }} ที่จะเสนอเพิ่มเติม</label>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <input type="text" id="offer_courses" class="form-control form-control-sm" name="offer_courses">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0 mt-5">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-lg btn-line btn-success">
                                    {{ __('Refer the patient') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
