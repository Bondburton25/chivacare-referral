@extends('layouts.app')

@section('pageTitle', __('Patient profile').' '.$patient->full_name)


@section('stylesheet')

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
    .timeline .timeline-item.active:after {
        background-color: #13795b
    }

    .timeline .timeline-item.current-stage:after {
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
        <div class="col h5"><i class="bi bi-user-fill"></i> {{ __('Patient profile') }}</div>
        {{-- <div class="col text-end"><a href="{{ route('patients.create') }}" class="btn btn-sm btn-primary">{{ __('Refer the patient') }} <i class="bi bi-person-badge-fill"></i></a></div> --}}
    </div>

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
                            {{ __('Health Status') }}
                            <span class="text-success">{{ __($patient->health_status->name) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            {{ __('Congenital disease') }}
                            <span class="text-success">{{ __($patient->congenital_disease) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            {{ __('Preliminary symptoms') }}
                            <span class="text-success mr-5">{{ __($patient->preliminary_symptoms) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            {{ __('Precautions') }} {{ __('Care instructions') }}
                            <span class="text-success mr-5">{{ __($patient->precautions) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            {{ __('Treatment history') }}
                            <span class="text-success mr-5">{{ __($patient->treatment_history) }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- <div class="alert alert-light border-0 mb-3 small">
                <div class="d-block">{{ $patient->health_status->name }}</div>
                {{ $patient->health_status->description }}
            </div> --}}

            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header">
                    {{ __('Relative information') }}
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item align-items-center border-0 px-0 mb-0">
                            {{ __('Name of relative') }}:
                            <span class="text-success">{{ $patient->contact_person }}</span>
                        </li>
                        <li class="list-group-item align-items-center border-0 px-0 mb-0">
                            {{ __('Relationship') }}:
                            <span class="text-success">{{ $patient->contact_person_relationship }}</span>
                        </li>
                        <li class="list-group-item align-items-center border-0 px-0 mb-0">
                            {{ __('Phone number') }}:
                            <span class="text-success">{{ $patient->phone_number }}</span>
                        </li>
                        <li class="list-group-item align-items-center border-0 px-0">
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
                        <li class="list-group-item align-items-center border-0 px-0 mb-0">
                            {{ __('Food') }}:
                            <span class="text-success">{{ $patient->food }}</span>
                        </li>
                        <li class="list-group-item align-items-center border-0 px-0 mb-0">
                            {{ __('Excretory system') }}:
                            <span class="text-success">{{ __($patient->excretory_system) }}</span>
                        </li>
                        <li class="list-group-item align-items-center border-0 px-0 mb-0">
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
                        <div class="title-card">ขั้นตอนการดำเนินการ</div>
                        <div class="button-update">
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal">
                                อัทเดทขั้นตอน <i class="bi bi-arrow-repeat"></i>
                            </button>
                            <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <form action="https://js-services-app.herokuapp.com/repairs/54/update" method="PUT" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="fXfyak0xExdaGmthOPUn31ijzCP8K8lGpz7suQFQ">                                            <div class="modal-header border-0">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <h4>เปลี่ยนแปลงขั้นตอนการดำเนินการ</h4>

                                                                                        </div>
                                        <div class="modal-footer border-0 d-flex justify-content-center mb-2">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                            <button type="submit" class="btn btn-primary">ยืนยัน</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <ul class="timeline">
                        @foreach ($stages as $stage)
                        <li class="timeline-item mb-4 {{ $stage->id == $patient->stage_id ? 'current-stage active' : '' }}">
                            <p class="mb-0">Stage {{ $stage->step }} {{ $stage->name }}</p>
                            <time class="text-muted">
                                @if($stage->step === 1)
                                    {{ __('Send patient information at') }} {{ $patient->created_at }}
                                @else
                                {{ __('Pending') }}
                                @endif
                            </time>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>


        </div>
    </div>
</div>

@endsection
