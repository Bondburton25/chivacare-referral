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
    .timeline .timeline-item.passed-stage:after,
    .timeline .timeline-item.current-stage:after,
    .timeline .timeline-item.last-stage:after {
        background-color: #198754
    }
    .timeline .timeline-item.next-stage:after {
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
        <div class="col h5"><i class="bi bi-user-fill"></i> {{ __('Patient profile') }}</div>
        @can('isAdmin')
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
        @endcan
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
                            {{ __('Refer number') }}
                            <span class="text-success">{{ __($patient->number) }}</span>
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
                            {{ __('Health status') }}
                            <span class="text-success">{{ $patient->health_status ? __($patient->health_status->name) : '' }}</span>
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
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
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
                        @can('isAdmin')
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
                                                <div class="modal-body text-center">
                                                    <h4>{{ __('Update on the patient referral process') }}</h4>
                                                    @if($nextStage)
                                                        <span>{{ __('Step') }}</span> <span class="text-success">{{ $nextStage->step }} {{ $nextStage->name }}</span>
                                                    @endif
                                                    @if($patient->stage->step == 3)
                                                        <div class="py-2">
                                                            <p>{{ __('Patient\'s relatives decide to stay') }}/{{ __('Backoff') }}</p>
                                                            <div class="d-flex justify-content-evenly">
                                                                <div>
                                                                    <input type="radio" class="btn-check" name="staying_decision" value="stay" id="staying" autocomplete="off" checked>
                                                                    <label class="btn btn-outline-success mr-2" for="staying"><i class="bi bi-check-circle-fill"></i> {{ __('Staying') }}</label>
                                                                </div>

                                                                <div>
                                                                    <input type="radio" class="btn-check" name="staying_decision" value="pending" id="pending" autocomplete="off">
                                                                    <label class="btn btn-outline-warning mr-2" for="pending"><i class="bi bi-question-diamond-fill"></i> {{ __('Still undecided') }}</label>
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
                                                            <textarea name="reason_not_staying" id="reason_not_staying" rows="2" class="form-control"></textarea>
                                                        </div>

                                                        <div class="mb-3 w-50 mx-auto mt-3">
                                                            <input class="form-check-input me-1" type="checkbox" value="1" id="physical_therapy_service" name="physical_therapy_service">
                                                            <label class="form-check-label" for="physical_therapy_service">{{ __('Stay with physical therapy services') }} </label>
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
                    <div class="pb-4">{{ __('Current stage') }} <span class="text-success">{{ __('Step') }} {{ $patient->stage->step }} {{ $patient->stage->name }}</span></div>
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
                                                        {{-- <div class="d-block">
                                                            ({{ $patient->created_at->diffForHumans() }})
                                                        </div> --}}
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
                                            {{ __('Decided made on') }} {{ $patient->decided_at }}
                                            <div class="d-block">
                                                    @if($patient->staying_decision !== 'pending')

                                                    <span class="text-{{ $patient->staying_decision == 'stay' ? 'success' : 'danger' }}"><i class="bi bi-{{ $patient->staying_decision == 'stay' ? 'check-circle text-success' : 'x-circle text-danger' }}-fill"></i>
                                                         {{ __('Decision') }}: {{ __($patient->staying_decision) }}</span>
                                                    @else
                                                        @if($patient->stage->step === 4)
                                                            {{ __('Still undecided') }}
                                                        @endif
                                                    @endif

                                                    @if($patient->reason_not_staying)
                                                        <div class="d-block">
                                                            {{ __('Reason') }}: {{ __($patient->reason_not_staying) }}
                                                        </div>
                                                    @endif

                                                    {{ $patient->physical_therapy_service ? __('Including physical therapy services') : ''  }}

                                                @if($patient->staying_decision == 'stay')
                                                <div class="d-block">
                                                    {{ __('Expected arrival date/time') }} {{ $patient->expected_arrive_date_time ? date('d/m/Y', strtotime($patient->expected_arrive_date_time)) : '' }} {{ __('Time') }} {{ date('H:m', strtotime($patient->expected_arrive_date_time)) }}
                                                    @if($patient->arrive_date_time == null)
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

                                                    @if($patient->expected_arrive_date_time && $patient->stage->step == 4)
                                                        <div class="d-block mt-3">
                                                            <button data-bs-toggle="modal" data-bs-target="#changeArriveDateModal" class="btn btn-outline-warning btn-sm">{{ __('Changing the expected date and time of service') }} <i class="bi bi-calendar-week-fill"></i>
                                                            </button>
                                                            <div class="modal fade" id="changeArriveDateModal" tabindex="-1" aria-labelledby="changeArriveDateModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <form action="{{ route('patients.update.expected-arrive',[$patient->id]) }}" method="POST" enctype="multipart/form-data">
                                                                    {{ method_field('PUT') }}
                                                                    @csrf
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                        <h1 class="modal-title fs-5" id="changeArriveDateModalLabel">{{ __('Changing the expected date and time of service') }}</h1>
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
        </div><!-- / card-md-4 -->
    </div>
</div>

@endsection
