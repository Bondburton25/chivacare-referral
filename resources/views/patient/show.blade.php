@extends('layouts.app')

@section('pageTitle', __('Patient profile').' '.$patient->full_name)

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
@section('stylesheet')

@if($patient->images()->exists())
<link href="{{ asset('css/fancybox/fancybox.css') }}" rel="stylesheet">
@endif

<style>
    .page-title {
        background: linear-gradient(#011023 -15.86%, #042558 21.51%, #5482B3 65.39%, #5482B3 100.33%, #7DA0CA);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-fill-color: transparent;
        font-weight: 700;
    }
    .timeline {
        border-left: 1px solid hsl(0, 0%, 90%);
        position: relative;
        list-style: none;
    }
    .timeline .timeline-item {
        position: relative;
    }
    .timeline .timeline-item:after {
        position: absolute;
        display: block;
        top: 0;
    }
    .timeline .timeline-item:after {
        background-color: hsl(0, 0%, 90%);
        left: -38px;
        border-radius: 50%;
        height: 11px;
        width: 11px;
        content: "";
    }
    .timeline .timeline-item.passed-stage:after,
    .timeline .timeline-item.current-stage:after,
    .timeline .timeline-item.last-stage:after {
        background-color: #198754
    }
    .timeline .timeline-item.next-stage:after,
    .timeline .timeline-item.last-stage:after {
        background-color: #198754;
        animation: blinker 1s linear infinite;
    }
    @keyframes blinker {
        50% {
            opacity: 0;
        }
    }
</style>

@endsection

@section('content')

<div class="container">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a class="link-underline-light" href="{{ route('home') }}">{{ __('List of all referred patients') }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ __('Patient profile') }} {{ $patient->fullname }}</li>
        </ol>
    </nav>

    <div class="row mb-3">
        <div class="col h5"><i class="bi bi-user-fill"></i> {{ __('Patient profile') }} {{ $patient->fullname }}</div>
        @canany(['isAdmin', 'isSuperAdmin'])
            @if($patient->end_service_at == null)
                @if($patient->stage->step > 4)
                    <div class="col text-end">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#endServiceModal">
                            {{ __('End of service') }}
                            <i class="bi bi-hourglass-bottom"></i>
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="endServiceModal" tabindex="-1" aria-labelledby="endServiceModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('patients.end-service',[$patient->id]) }}" method="POST" enctype="multipart/form-data">
                                        {{ method_field('PUT') }}
                                        @csrf
                                    <div class="modal-header border-0">
                                    <h1 class="modal-title fs-5" id="endServiceModalLabel">{{ __('End of service') }}</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <h4>{{ __('Do you want to end services for this patient?') }}</h4>
                                    </div>
                                    <div class="modal-footer border-0 d-flex justify-content-center align-items-center">
                                        <button type="submit" class="btn btn-primary">{{ __('Confirm') }}</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                    </div>
                                </form>
                            </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        @endcan
    </div><!-- / row -->

    <div class="row">

        <div class="col-md-8 col-12">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header">{{ __('Patient information') }}</div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 ">
                            {{ __('First Name') }}-{{ __('Last Name') }}
                            <span class="text-success">{{ $patient->full_name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-top border-0 px-0">
                            {{ __('Refer number') }}
                            <span class="text-success">{{ __($patient->number) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-top border-0 px-0">
                            {{ __('Gender') }}
                            <span class="text-success">{{ __($patient->gender) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-top border-0 px-0">
                            {{ __('Birth date') }}
                            <span class="text-{{ $patient->birth_date ? 'success' : 'muted' }}">{{ $patient->birth_date ? $patient->birth_date : __('No data found') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-top border-0 px-0">
                            {{ __('Age') }}
                                @if($patient->birth_date)
                                    <span class="text-success">
                                        {{ $patient->age().' '.__('Years') }}
                                    </span>
                                @else
                                    <span class="text-{{ $patient->age ? 'success' : 'muted' }}">
                                        {{ $patient->age ? $patient->age.' '.__('Years') : __('No data found') }}
                                    </span>
                                @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-top border-0 px-0">
                            {{ __('Weight') }}
                            <span class="text-success">{{ $patient->weight }} {{ __('kg') }}.</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-top border-0 px-0">
                            {{ __('Height') }}
                            <span class="text-success">{{ $patient->height }} {{ __('cm') }}.</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-top border-0 px-0">
                            {{ __('Health status') }}
                            <div><span class="text-success">{{ $patient->health_status ? __($patient->health_status->name) : '' }}</span>
                                @if($patient->health_status)
                                <br>
                                <button type="button" class="text-muted small btn-sm btn p-0 text-end float-end" data-bs-toggle="modal" data-bs-target="#exampleModal">คลิกเพื่อดูคำอธิบาย <i class="bi bi-info-circle-fill"></i></button>
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header border-0">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $patient->health_status->name }}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-star">
                                            <span class="text-success">{{ $patient->health_status->name }}</span><span class="text-muted"> {{ __('is') }} {{ $patient->health_status->description }}</span>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-top border-0 px-0">
                            {{ __('Congenital disease') }}
                            <span class="text-success">{{ __($patient->congenital_disease) }}</span>
                        </li>

                        <li class="list-group-item border-0 px-0 {{ $patient->preliminary_symptoms ? '' : 'd-flex justify-content-between align-items-top' }}">
                            <div>{{ __('Preliminary symptoms') }}</div>
                            <span class="text-{{ $patient->preliminary_symptoms ? 'success' : 'muted d-block' }} mr-5">{{ $patient->preliminary_symptoms ? $patient->preliminary_symptoms : __('No data found') }}</span>
                        </li>

                        <li class="list-group-item border-0 px-0 {{ $patient->precautions ? '' : 'd-flex justify-content-between align-items-top' }}">
                            <div>{{ __('Precautions') }}</div>
                            <span class="text-{{ $patient->precautions ? 'success' : 'muted d-block' }} mr-5">{{ $patient->precautions ? $patient->precautions : __('No data found') }}</span>
                        </li>

                        <li class="list-group-item border-0 px-0 {{ $patient->treatment_history ? '' : 'd-flex justify-content-between align-items-top' }}">
                            <div>{{ __('Treatment history') }}</div>
                            <span class="text-{{ $patient->treatment_history ? 'success' : 'muted d-block' }} mr-5">{{ $patient->treatment_history ? $patient->treatment_history : __('No data found') }}</span>
                        </li>

                        <li class="list-group-item border-0 px-0 {{ $patient->symptom_assessment ? '' : 'd-flex justify-content-between align-items-top' }}">
                            <div>{{ __('Symptoms assessed after first seeing the patient') }}</div>
                            <span class="text-{{ $patient->symptom_assessment ? 'success' : 'muted d-block' }} mr-5">{{ $patient->symptom_assessment ? $patient->symptom_assessment : __('No data found') }}</span>
                        </li>

                        <li class="list-group-item border-0 px-0 d-flex justify-content-between align-items-top">
                            <div>{{ __('Vital signs first monitor') }}</div>
                            <span class="text-{{ $patient->vital_signs_first_monitor ? 'success' : 'muted d-block' }} mr-5">{{ $patient->vital_signs_first_monitor ? $patient->vital_signs_first_monitor : __('No data found') }}</span>
                        </li>

                        <li class="list-group-item border-0 px-0 {{ $patient->first_checkup ? '' : 'd-flex justify-content-between align-items-top' }}">
                            <div class="w-50">{{ __('First checkup') }}</div>
                            <span class="text-{{ $patient->first_checkup ? 'success' : 'muted d-block' }} mr-5">{{ $patient->first_checkup ? $patient->first_checkup : __('No data found') }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 fw-bold">
                            {{ __('การประเมินความรู้สึกตัว') }}
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-top border-0 px-0">
                            {{ __('Evaluate eye opening') }}
                            <span class="text-{{ $patient->evaluate_eye_opening ? 'success' : 'muted' }} mr-5">
                                {{ $patient->evaluate_eye_opening ? __('Level') .' '. 'E'.$patient->evaluate_eye_opening : __('No data found') }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-top border-0 px-0">
                            {{ __('Verbal response') }}
                            <span class="text-{{ $patient->verbal_response ? 'success' : 'muted' }} mr-5">
                                {{ $patient->verbal_response ? __('Level') .' '. 'V'.$patient->verbal_response : __('No data found') }}
                            </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-top border-0 px-0">
                            {{ __('Motor response') }}
                            <span class="text-{{ $patient->motor_response ? 'success' : 'muted' }} mr-5">
                                {{ $patient->motor_response ? __('Level') .' '. 'M'.$patient->motor_response : __('No data found') }}
                            </span>
                        </li>
                    </ul>
                </div><!-- / card-body -->
            </div><!-- / card -->

            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header">
                    {{ __('Relative information') }}
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-0">
                            {{ __('Name of relative') }}:
                            <span class="text-success">{{ $patient->contact_person }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-0">
                            {{ __('Relationship') }}:
                            <span class="text-success">{{ $patient->contact_person_relationship }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-0">
                            {{ __('Phone number') }}:
                            <span class="text-success">{{ $patient->phone_number }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-top border-0 px-0">
                            {{ __('Relative Expectations') }}:
                            <span class="text-success">{{ $patient->expectations }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-5">
                <div class="card-header">
                    {{ __('Additional information') }}
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-0">
                            {{ __('Food') }}:
                            <span class="text-success">{{ $patient->food }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-0">
                            {{ __('Excretory system') }}:
                            <span class="text-success">{{ __($patient->excretory_system) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-0">
                            {{ __('Room type') }}:
                            <span class="text-success">
                                {{ $patient->room_type == 'sharing' ? __('Sharing room') : ($patient->room_type == 'single' ? __('Shared room') : __('Don\'t know yet') ) }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-12">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="title-card">{{ __('Action steps') }}</div>
                        @canany(['isAdmin', 'isSuperAdmin'])
                        <div class="button-update">
                            @if($patient->staying_decision != 'backoff')
                                @if($patient->stage->step < 5)
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal">
                                    {{ __('Update steps') }}
                                    <i class="bi bi-arrow-repeat"></i>
                                </button>
                                <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('patients.update',[$patient->id]) }}" method="POST" enctype="multipart/form-data">
                                                {{ method_field('PUT') }}
                                                @csrf
                                                <div class="modal-header border-0">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="text-center">
                                                        <h4>{{ __('Update on the patient referral process') }}</h4>
                                                        @if($nextStage)
                                                            <span>{{ __('Step') }}</span> <span class="text-success">{{ $nextStage->step }} {{ $nextStage->name }}</span>
                                                        @endif
                                                    </div>

                                                    @if($patient->stage->step == 3)
                                                        <div class="py-2">
                                                            <div class="d-flex justify-content-evenly">
                                                                <div>
                                                                    <input type="radio" class="btn-check" name="staying_decision" value="stay" id="staying" autocomplete="off" checked>
                                                                    <label class="btn btn-outline-success mr-2" for="staying"><i class="bi bi-check-circle-fill"></i> {{ __('Staying') }}</label>
                                                                </div>
                                                                <div><input type="radio" class="btn-check" name="staying_decision" value="backoff" id="backoff" autocomplete="off">
                                                                    <label class="btn btn-outline-danger" for="backoff"><i class="bi bi-x-circle-fill"></i> {{ __('Backoff') }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 w-50 mx-auto mt-3">
                                                            <label for="expected_arrive_date_time" class="form-label">{{ __('Expected arrival date/time') }} ({{ __('In case of staying') }})</label>
                                                            <input type="datetime-local" id="expected_arrive_date_time" name="expected_arrive_date_time" class="form-control">
                                                        </div>

                                                        <div class="mb-3 w-50 mx-auto mt-3">
                                                            <label for="reason_not_staying" class="form-label">{{ __('Backoff reason') }} ({{ __('In case not use the service') }})</label>
                                                            <textarea name="reason_not_staying" id="reason_not_staying" rows="2" class="form-control @error('room_type') is-invalid @enderror"></textarea>
                                                            @error('reason_not_staying')
                                                                <span class="invalid-feedback d-block" role="alert">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        <div class="mb-3 w-50 mx-auto mt-3">
                                                            <input class="form-check-input me-1" type="checkbox" value="1" id="physical_therapy_service" name="physical_therapy_service">
                                                            <label class="form-check-label" for="physical_therapy_service">{{ __('Stay with physical therapy services') }} </label>
                                                        </div>
                                                    @endif

                                                    @if($patient->stage->step == 4)
                                                        <div class="row mt-3">
                                                            <div class="col-sm-6 col-12">
                                                                <div class="mb-3">
                                                                    <label for="arrive_date_time" class="form-label">{{ __('Date/time of patient admission') }} <span class="text-danger">*</span></label>
                                                                    <input type="datetime-local" id="arrive_date_time" name="arrive_date_time" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-12">
                                                                <div class="mb-3">
                                                                    <label for="underlying_disease" class="form-label">U/D</label>
                                                                    <input type="text" class="form-control" id="underlying_disease" value="{{ $patient->underlying_disease }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-12">
                                                                <div class="mb-3">
                                                                    <label for="treatment_history" class="form-label">{{ __('History of treatment') }}</label>
                                                                    <textarea name="treatment_history" class="form-control" id="treatment_history" rows="2">{{ $patient->treatment_history }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-12">
                                                                <div class="mb-3">
                                                                    <label for="symptom_assessment" class="form-label">{{ __('Symptoms assessed after first seeing the patient') }}</label>
                                                                    <textarea name="symptom_assessment" class="form-control" id="symptom_assessment" rows="2"></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3 col-sm-6 col-12">
                                                                <label for="first_checkup" class="form-label">{{ __('First checkup') }}</label>
                                                                <textarea name="first_checkup" class="form-control" id="first_checkup" rows="2"></textarea>
                                                            </div>

                                                            <div class="mb-3 col-sm-6 col-12">
                                                                <label for="vital_signs_first_monitor" class="form-label">{{ __('Vital signs first monitor') }}</label>
                                                                <textarea name="vital_signs_first_monitor" class="form-control" id="vital_signs_first_monitor" rows="2"></textarea>
                                                            </div>


                                                        </div>

                                                        <div class="table-responsive">
                                                            <table class="table table-sm align-middle small bg-primary-subtle">
                                                                <tr>
                                                                    <td colspan="7">{{ __('Assessment of consciousness') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label for="evaluate_eye_opening" class="form-label">{{ __('Evaluate eye opening') }} <i class="fa-solid fa-eye"></i></label></td>
                                                                    <td>
                                                                        <input type="radio" class="btn-check" name="evaluate_eye_opening" id="evaluate_eye_opening_1" autocomplete="off" checked value="1">
                                                                        <label class="btn" for="evaluate_eye_opening_1">E1</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="radio" class="btn-check" name="evaluate_eye_opening" id="evaluate_eye_opening_2" autocomplete="off" value="2">
                                                                        <label class="btn" for="evaluate_eye_opening_2">E2</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="radio" class="btn-check" name="evaluate_eye_opening" id="evaluate_eye_opening_3" autocomplete="off" value="3">
                                                                        <label class="btn" for="evaluate_eye_opening_3">E3</label>
                                                                    </td>
                                                                    <td colspan="3">
                                                                        <input type="radio" class="btn-check" name="evaluate_eye_opening" id="evaluate_eye_opening_4" autocomplete="off" value="4">
                                                                        <label class="btn" for="evaluate_eye_opening_4">E4</label>
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td><label for="verbal_response" class="form-label">ประเมินการสื่อสาร<i class="fa-solid fa-ear-listen"></i></label></td>
                                                                    <td><input type="radio" class="btn-check" name="verbal_response" id="verbal_response_1" autocomplete="off" value="1" checked><label class="btn" for="verbal_response_1">V1</label></td>
                                                                    <td>
                                                                        <input type="radio" class="btn-check" name="verbal_response" id="verbal_response_2" autocomplete="off" value="2">
                                                                        <label class="btn" for="verbal_response_2">V2</label>
                                                                    </td>

                                                                    <td>
                                                                        <input type="radio" class="btn-check" name="verbal_response" id="verbal_response_3" autocomplete="off" value="3">
                                                                        <label class="btn" for="verbal_response_3">V3</label>
                                                                    </td>

                                                                    <td>
                                                                        <input type="radio" class="btn-check" name="verbal_response" id="verbal_response_4" autocomplete="off" value="4">
                                                                        <label class="btn" for="verbal_response_4">V4</label>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input type="radio" class="btn-check" name="verbal_response" id="verbal_response_5" autocomplete="off" value="5">
                                                                        <label class="btn" for="verbal_response_5">V5</label>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label for="motor_response" class="form-label">ประเมินความรู้สึก <i class="fa-solid fa-child-reaching"></i></label></td>
                                                                    <td><input type="radio" class="btn-check" name="motor_response" id="motor_response_1" autocomplete="off" checked value="1">
                                                                        <label class="btn" for="motor_response_1">M1</label></td>
                                                                    <td>
                                                                        <input type="radio" class="btn-check" name="motor_response" id="motor_response_2" autocomplete="off" value="2">
                                                                        <label class="btn" for="motor_response_2">M2</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="radio" class="btn-check" name="motor_response" id="motor_response_3" autocomplete="off" value="3">
                                                                        <label class="btn" for="motor_response_3">M3</label>
                                                                    </td>

                                                                    <td>
                                                                        <input type="radio" class="btn-check" name="motor_response" id="motor_response_4" autocomplete="off" value="4">
                                                                        <label class="btn" for="motor_response_4">M4</label>
                                                                    </td>

                                                                    <td>
                                                                        <input type="radio" class="btn-check" name="motor_response" id="motor_response_5" autocomplete="off" value="5">
                                                                        <label class="btn" for="motor_response_5">M5</label>
                                                                    </td>

                                                                    <td>
                                                                        <input type="radio" class="btn-check" name="motor_response" id="motor_response_6" autocomplete="off" value="6">
                                                                        <label class="btn" for="motor_response_6">M6</label>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer border-0 d-flex justify-content-center mb-2">
                                                    <button type="submit" class="btn btn-success">{{ __('Confirm') }}</button>
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endif
                        </div>
                        @endcan
                    </div>
                </div>
                <div class="card-body pt-4 px-4">
                    @if($patient->end_service_at == null)
                    <div class="pb-4">{{ __('Current stage') }} <span class="text-success">{{ __('Step') }} {{ $patient->stage->step }} {{ $patient->stage->name }}</span></div>
                    @endif
                    <ul class="timeline">
                        @foreach ($stages as $stage)
                            <li class="timeline-item mb-4
                                {{ $stage->step == $patient->stage->step ? 'current-stage' : '' }}
                                {{ $patient->stage->step > $stage->step ? 'passed-stage' : '' }}
                                {{ $stage->step == $patient->stage->step+1 ? 'next-stage' : '' }}
                                ">
                                <p class="mb-0">{{ __('Step') }} <span class="text-success">{{ $stage->step }} {{ $stage->name }}</p></span>
                                <time class="text-muted">
                                    @if($stage->step <= $patient->stage->step)
                                        @if($stage->step == 1)
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="{{ $patient->referred_by->avatar }}" class="img-profile rounded-circle d-inline-block">
                                                </div>
                                                <div class="flex-grow-1 ms-2 referred_person">
                                                    {{ __($patient->referred_by->role) }} <span class="text-primary">{{ $patient->referred_by->fullname }}</span>
                                                    <div class="d-block created_at">
                                                        {{ __('Sent patient information at') }} {{ $patient->created_at }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if($stage->step == 2)
                                            {{ __('ติดต่อญาติคนไข้เมื่อ') }} {{ $patient->contacted_relative_at }}
                                        @endif

                                        @if($stage->step == 3)
                                            {{ __('ญาติคนไข้เข้าดูสถานเมื่อ') }} {{ $patient->contacted_relative_at }}
                                        @endif

                                        @if($stage->step === 4)
                                            <div class="d-block">
                                                @if($patient->staying_decision === 'pending')
                                                        @if($patient->stage->step === 4)
                                                            <span class="text-warning">{{ __('Still undecided') }}</span>
                                                        @endif
                                                @else
                                                    <span class="text-{{ $patient->staying_decision == 'stay' ? 'success' : 'danger' }}">
                                                        <i class="bi bi-person-{{ $patient->staying_decision == 'stay' ? 'heart text-success' : 'fill-x text-danger' }}"></i>
                                                        {{ __('Decision') }}: {{ __($patient->staying_decision) }}
                                                    </span>
                                                @endif

                                                @if($patient->reason_not_staying)
                                                    <div class="d-block">
                                                        <i class="bi bi-chat-right-fill"></i> {{ __('Reason') }}: <span class="text-dark"><i>{{ __($patient->reason_not_staying) }}</i></span>
                                                    </div>
                                                @endif

                                            <div class="d-block">{{ __('At the time') }} {{ $patient->decided_at }}</div>

                                                @if($patient->staying_decision == 'stay')
                                                <div class="d-block">
                                                    {{ __('Expected arrival date/time') }}
                                                    {{ $patient->expected_arrive_date_time ? date('d/m/Y', strtotime($patient->expected_arrive_date_time)).' '.date('H:m', strtotime($patient->expected_arrive_date_time)) : 'ยังไม่ได้ระบุวันเวลา' }}

                                                    @if($patient->arrive_date_time == null && $patient->expected_arrive_date_time != null)
                                                        <span class="small d-block text-muted" id="days-to-come">
                                                            @if(date('Y-m-d', strtotime($patient->expected_arrive_date_time)) > date('Y-m-d'))
                                                                ({{ __('More') }} {{ Carbon\Carbon::parse($patient->expected_arrive_date_time)->diffInDays(date('Y-m-d')) }} {{ __('Day(s) to come') }})
                                                            @elseif(date('Y-m-d', strtotime($patient->expected_arrive_date_time)) < date('Y-m-d'))
                                                                <span class="text-danger">
                                                                    @if(Carbon\Carbon::parse($patient->expected_arrive_date_time)->diffInDays(date('Y-m-d')) == 0)
                                                                        {{ __('Yesterday') }} {{ __('Time') }} {{ date('H:m', strtotime($patient->expected_arrive_date_time)) }}
                                                                    @else
                                                                        ({{ Carbon\Carbon::parse($patient->expected_arrive_date_time)->diffInDays(date('Y-m-d'))+1 }} {{ __('Day(s) ago') }})
                                                                    @endif
                                                                </span>
                                                            @else
                                                            <span class="text-success">
                                                                {{ __('Today') }} {{ __('Time') }} {{ date('H:m', strtotime($patient->expected_arrive_date_time)) }}
                                                            </span>
                                                            @endif
                                                        </span>
                                                    @endif

                                                    @if($patient->expected_arrive_date_time or $patient->expected_arrive_date_time == null && $patient->stage->step == 4)
                                                    @canany(['isAdmin', 'isSuperAdmin'])
                                                        <div class="d-block mt-3">
                                                            <button data-bs-toggle="modal" data-bs-target="#changeArriveDateModal" class="btn btn-outline-warning btn-sm">{{ __('Set date time to arrive') }} <i class="bi bi-calendar-week-fill"></i>
                                                            </button>
                                                            <div class="modal fade" id="changeArriveDateModal" tabindex="-1" aria-labelledby="changeArriveDateModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <form action="{{ route('patients.update.expected-arrive',[$patient->id]) }}" method="POST" enctype="multipart/form-data">
                                                                    {{ method_field('PUT') }}
                                                                    @csrf
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                        <h1 class="modal-title fs-5" id="changeArriveDateModalLabel">{{ __('Set date time to arrive') }}</h1>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">

                                                                            <div class="mb-3 w-50 mx-auto mt-3">
                                                                                <label for="expected_arrive_date_time" class="form-label">{{ __('Expected arrival date/time') }}</label>
                                                                                <input type="datetime-local" id="expected_arrive_date_time" name="expected_arrive_date_time" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer d-flex justify-content-center align-items-center">
                                                                            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> {{ __('Cancel') }}</button>
                                                                        </div>
                                                                    </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endcan
                                                    @endif
                                                </div>
                                                @endif
                                            </div>
                                        @endif

                                        @if($stage->step === 5)
                                            {{ $patient->arrive_date_time ? __('Completed at') .' '. $patient->arrive_date_time : '' }}
                                            @if(date('Y-m-d', strtotime($patient->arrive_date_time)) !== date('Y-m-d'))
                                                ({{ Carbon\Carbon::parse($patient->arrive_date_time)->diffInDays(date('Y-m-d'))+1 }} {{ __('Day(s) ago') }})
                                            @endif
                                        @endif

                                        @if($stage->step === 6)
                                            {{ __('The patient completed 1 month of stay on') }} {{ $patient->admission_date_one_month }}
                                        @endif
                                    @else
                                        <i class="bi bi-hourglass-top"></i> {{ __('Pending') }}
                                    @endif
                                </time>
                            </li>
                        @endforeach
                        @if($patient->end_service_at)
                            <li class="timeline-item mb-4 last-stage">
                                <span>{{ __('End of service') }}</span>
                                <div class="text-muted">{{ __('The patient end service at') }} {{ $patient->end_service_at }}</div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            @if(Carbon\Carbon::parse($patient->arrive_date_time)->diffInDays(date('Y-m-d'))+1 >= 30)
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    {{ __('Patient referral fee') }}
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @if(Carbon\Carbon::parse($patient->arrive_date_time)->diffInDays(date('Y-m-d'))+1 >= 30)
                        <li class="list-group-item d-flex justify-content-between align-items-start border-0">
                            <div class="ms-2 me-auto commission-month">
                                <div class="item">{{ __('First month') }}</div>
                            </div>
                            <div class="amount">
                                {{ number_format(1000,2) }} {{ __('Baht') }}
                            </div>
                        </li>
                        @endif

                        @if(Carbon\Carbon::parse($patient->arrive_date_time)->diffInDays(date('Y-m-d'))+1 > 30)
                        <li class="list-group-item d-flex justify-content-between align-items-start border-0">
                            <div class="ms-2 me-auto commission-month">
                              <div class="item">
                                {{ __('Month') }} 2
                             </div>
                            </div>
                            <div class="amount">
                                {{ number_format(1000,2) }} {{ __('Baht') }}
                            </div>
                        </li>
                        @endif

                        @if(Carbon\Carbon::parse($patient->arrive_date_time)->diffInDays(date('Y-m-d'))+1 > 90)
                        <li class="list-group-item d-flex justify-content-between align-items-start border-0">
                            <div class="ms-2 me-auto commission-month">
                              <div class="item">
                                {{ __('Month') }} 3
                             </div>
                            </div>
                            <div class="amount">
                                {{ number_format(1500,2) }} {{ __('Baht') }}
                            </div>
                        </li>
                        @endif

                        <li class="list-group-item d-flex justify-content-between align-items-start border-0 text-success">
                            <div class="ms-2 me-auto">
                              <div class="fw-normal">{{ __('Total patient referral fee') }}</div>
                            </div>
                            <span class="fw-normal">
                                @if(Carbon\Carbon::parse($patient->arrive_date_time)->diffInDays(date('Y-m-d'))+1 > 90)
                                    {{ number_format(3500,2) }} {{ __('Baht') }}
                                @elseif(Carbon\Carbon::parse($patient->arrive_date_time)->diffInDays(date('Y-m-d'))+1 > 30)
                                    {{ number_format(2000,2) }} {{ __('Baht') }}
                                @else
                                    {{ number_format(1000,2) }} {{ __('Baht') }}
                                @endif
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
            @endif

            @if($patient->images()->exists())
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="title-card">{{ __('ภาพของคนไข้') }}</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($patient->images as $image)
                        <div class="col-sm-4 col-6">
                            <a href="{{ Storage::disk('s3')->temporaryUrl('upload/'.$image->image, now()->addMinutes(30)) }}" data-fancybox data-caption="{{ $image->caption }} {{ $image->description }}">
                                {{-- <img src="{{ asset('storage/images/' . $image->image) }}" class="img-thumbnail "> --}}
                                <img src="{{ Storage::disk('s3')->temporaryUrl('upload/'.$image->image, now()->addMinutes(30)) }}" class="img-thumbnail">
                            </a>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
            @endif

        </div><!-- / card-md-4 -->
    </div>
</div>

@endsection

@section('javascript')
    @if($patient->images()->exists())
        <script src="{{ asset('js/fancybox/fancybox.umd.js') }}"></script>
        <script>
            Fancybox.bind("[data-fancybox]", {});
        </script>
    @endif
@endsection
