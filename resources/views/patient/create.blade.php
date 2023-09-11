@extends('layouts.app')

@section('pageTitle', __('Refer the patient'))

@section('content')

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-4 col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header fw-normal border-0">{{ __('Refer the patient') }}</div>
                    <img src="{{ asset('images/doctor-using-smarthone-office.jpg') }}" class="border-0 link-opacity-10-hover" alt="">
                <div class="card-body py-4">
                    <form method="POST" action="{{ route('patients.store') }}" file="true" enctype="multipart/form-data">
                    @csrf
                        <span class="fw-normal mb-3">{{ __('Patient information') }}</span>

                        <div class="row mb-2">
                            <label for="first_name" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }} <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input id="first_name" type="text" class="form-control form-control-sm @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" autocomplete="first_name" autofocus>
                                @error('first_name')
                                    <span class="invalid-feedback d-block" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="last_name" class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }} <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input id="last_name" type="text" class="form-control form-control-sm @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" autocomplete="last_name" autofocus>
                                @error('last_name')
                                    <span class="invalid-feedback d-block" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="birth_date" class="col-md-4 col-form-label text-md-end">{{ __('Birth date') }} <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input id="birth_date" type="date" class="form-control form-control-sm @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date') }}" autocomplete="birth_date" autofocus>
                                @error('birth_date')
                                    <span class="invalid-feedback d-block" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="gender" class="col-md-4 col-form-label text-md-end">{{ __('Gender') }} <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select name="gender" value="{{ old('gender') }}" id="gender" class="form-control form-control-sm @error('gender') is-invalid @enderror">
                                    <option value="" selected>{{ __('Please select') }}</option>
                                    <option value="male">{{ __('Male') }}</option>
                                    <option value="female">{{ __('Female') }}</option>
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback d-block" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="weight" class="col-md-4 col-form-label text-md-end">{{ __('Weight') }}</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="number" class="form-control form-control-sm" id="weight" name="weight">
                                    <span class="input-group-text" id="weight_label">{{ __('kg') }}.</span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="height" class="col-md-4 col-form-label text-md-end">{{ __('Height') }}</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="number" class="form-control form-control-sm" id="height" name="height">
                                    <span class="input-group-text" id="weight_label">{{ __('cm') }}.</span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="health_status" class="col-md-4 col-form-label text-md-end">{{ __('Health status') }} <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select name="health_status" id="health_status" class="form-control form-control-sm">
                                    <option value="">{{ __('Please select') }}</option>
                                    <option value="very_stable">{{ __('very_stable') }}</option>
                                    <option value="stable">{{ __('Stable') }}</option>
                                    <option value="moderate_stable">{{ __('Moderate stable') }}</option>
                                    <option value="unstable">{{ __('Unstable') }}</option>
                                    <option value="critically_ill">{{ __('Critically ill') }}</option>
                                    <option value="unknown">{{ __('Unknown') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="congenital_disease" class="col-md-4 col-form-label text-md-end">{{ __('Congenital disease') }}</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <textarea name="congenital_disease" id="congenital_disease" class="form-control form-control-sm" rows="2"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="preliminary_symptoms" class="col-md-4 col-form-label text-md-end">{{ __('Preliminary symptoms') }} <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <textarea name="preliminary_symptoms" id="preliminary_symptoms" class="form-control form-control-sm @error('preliminary_symptoms') is-invalid @enderror" rows="2"></textarea>
                                </div>
                                @error('preliminary_symptoms')
                                    <span class="invalid-feedback d-block" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="precautions" class="col-md-4 col-form-label text-md-end">{{ __('Precautions') }} <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <textarea name="precautions" id="precautions" class="form-control form-control-sm @error('precautions') is-invalid @enderror" rows="2" placeholder="{{ __('Care instructions') }}"></textarea>
                                </div>
                                @error('precautions')
                                    <span class="invalid-feedback d-block" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <label for="treatment_history" class="col-md-4 col-form-label text-md-end">{{ __('Treatment history') }}</label>
                            <div class="col-md-8">
                                <div class="input-group mb-3">
                                    <textarea name="treatment_history" id="treatment_history" class="form-control form-control-sm" rows="2"></textarea>
                                </div>
                            </div>
                        </div>

                        <span class="fw-normal mb-3">{{ __('Relative information') }}</span>

                        <div class="row mb-2">
                            <label for="contact_person" class="col-md-4 col-form-label text-md-end">{{ __('Name of relative') }} <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm @error('contact_person') is-invalid @enderror" id="contact_person" name="contact_person">
                                </div>
                                @error('contact_person')
                                    <span class="invalid-feedback d-block" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="contact_person_relationship" class="col-md-4 col-form-label text-md-end">{{ __('Relationship') }} <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control form-control-sm @error('contact_person_relationship') is-invalid @enderror" id="contact_person_relationship" name="contact_person_relationship">
                                @error('contact_person_relationship')
                                    <span class="invalid-feedback d-block" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="phone_number" class="col-md-4 col-form-label text-md-end">{{ __('Phone number') }}  <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control form-control-sm @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number">
                                @error('phone_number')
                                    <span class="invalid-feedback d-block" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="expected_arrive" class="col-md-4 col-form-label text-md-end">{{ __('Expected arrive') }}</label>
                            <div class="col-md-8">
                                <select name="expected_arrive" id="expected_arrive" class="form-control form-control-sm">
                                    <option value="" selected>{{ __('Please select') }}</option>
                                    <option value="immediately">{{ __('Immediately') }}</option>
                                    <option value="within_one_week">{{ __('Within one week') }}</option>
                                    <option value="within_one_month">{{ __('Within one month') }}</option>
                                    <option value="indecisive">{{ __('Indecisive') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="recommend_service" class="col-md-4 col-form-label text-md-end">{{ __('Recommend additional recovery programs') }}</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <textarea name="recommend_service" id="recommend_service" class="form-control form-control-sm" rows="2" ></textarea>
                                </div>
                            </div>
                        </div>

                        <span class="fw-normal mb-3">{{ __('Additional information') }}</span>

                        <div class="row mb-2">
                            <label for="food" class="col-md-4 col-form-label text-md-end">{{ __('Food') }}</label>
                            <div class="col-md-8">
                                <select name="food" id="food" class="form-control form-control-sm">
                                    <option value="" selected>{{ __('Please select') }}</option>
                                    <option value="{{ __('Normal food') }}">{{ __('Normal food') }}</option>
                                    <option value="{{ __('Soft food') }}">{{ __('Soft food') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="other_food" class="col-md-4 col-form-label text-md-end">{{ __('Other food') }} {{ __('please specify') }}</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control form-control-sm" name="other_food">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="excretory_system" class="col-md-4 col-form-label text-md-end">{{ __('Excretory system') }}</label>
                            <div class="col-md-8">
                                <select name="excretory_system" id="food" class="form-control form-control-sm">
                                    <option value="" selected>{{ __('Please select') }}</option>
                                    <option value="self_excretion">{{ __('Self excretion') }}</option>
                                    <option value="diaper">{{ __('Diaper') }}</option>
                                    <option value="tubing">{{ __('Tubing') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="expectations" class="col-md-4 col-form-label text-md-end">{{ __('Relative Expectations') }}</label>
                            <div class="col-md-8">
                                <select name="expectations" id="expectations" class="form-control form-control-sm">
                                    <option value="" selected>{{ __('Please select') }}</option>
                                    <option value="{{ __('Long-term care') }}">{{ __('Long-term care') }}</option>
                                    <option value="{{ __('Restore strength') }}">{{ __('Restore strength') }}</option>
                                    <option value="{{ __('Palliative care') }}">{{ __('Palliative care') }}</option>
                                    <option value="{{ __('End of life') }}">{{ __('End of life') }}</option>
                                    <option value="{{ __('Other') }}">{{ __('Other') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <label for="room_type" class="col-md-4 col-form-label text-md-end">{{ __('Room type') }}</label>
                            <div class="col-md-8">
                                <select name="room_type" id="room_type" class="form-control form-control-sm @error('room_type') is-invalid @enderror">
                                    <option value="" selected>{{ __('Please select') }}</option>
                                    <option value="single">{{ __('Single room') }}</option>
                                    <option value="sharing">{{ __('Shared room') }}</option>
                                    <option value="">{{ __('Don\'t know yet') }}</option>
                                </select>
                                @error('room_type')
                                    <span class="invalid-feedback d-block" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
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
