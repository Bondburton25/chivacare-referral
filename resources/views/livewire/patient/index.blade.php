<div>
    <div class="d-block text-muted mb-2" id="filter">
        <i class="bi bi-funnel-fill"></i> {{ __('Filter information by') }}:
    </div>
    <div class="row mb-3">
        <div class="col-sm-3 col-12">
            <div class="mb-2">
                <input type="text" wire:model="search" class="form-control form-control-sm" placeholder="{{ __('Search patients') }} {{ __('By name, HN number, contact person') }}...">
            </div>
        </div>
        <div class="col-sm-3 col-12">
            <div class="mb-2">
                <select wire:model="byStage" class="form-control form-control-sm">
                    <option value="" selected>{{ __('Show all stage') }}</option>
                    @foreach($stages as $stage)
                        <option value="{{ $stage->id }}">{{ __('Step') }} {{ $stage->step }} {{ $stage->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-3 col-12">
            <div class="mb-2">
                <select wire:model="byHealthStatus" class="form-control form-control-sm">
                    <option value="" selected>{{ __('Show all health status') }}</option>
                    @foreach ($health_statuses as $health_status)
                        <option value="{{ $health_status->id }}">{{ $health_status->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-sm-3 col-12">
            <div class="mb-2">
                <select wire:model="byArriveDate" class="form-control form-control-sm">
                    <option value="" selected>{{ __('Length of stay') }}</option>
                    <option value="30">30 Days</option>
                    <option value="60">60 Days</option>
                    <option value="90">90 Days</option>
                </select>
            </div>
        </div>

    </div>
    <div class="table-responsive d-none d-sm-block">
        <table class="table table-striped align-middle caption-top">
            <caption class="text-muted">
                <small>{{ __('Total found') }} {{ $patients->total() }} {{ __('Item(s)') }} </small>
            </caption>
            <tbody>
                <tr>
                    <td>HN Hosptial</td>
                    <td>{{ __('Name') }}-{{ __('Last name') }} </td>
                    <td>{{ __('Stage') }}</td>
                    <td>{{ __('Health status') }}</td>
                    <td>{{ __('Arrival date') }}</td>
                    <td>{{ __('Action') }}</td>
                </tr>
                @forelse($patients as $patient)
                <tr wire:loading.class.deplay="opacity-50" class="small">
                    <td>{{ $patient->number }}</td>
                    <td>{{ $patient->full_name }}</td>
                    <td>
                        <span class="badge rounded-pill p-2 fw-normal bg-success-subtle text-success">
                            <i class="bi bi-check2-circle"></i>
                            {{ $patient->stage->name }}
                        </span>
                    </td>
                    <td>{{ $patient->health_status()->exists() ? __('Health status').' '.$patient->health_status->name : __('Patient\'s condition unknown') }}</td>
                    <td>
                        @if($patient->arrive_date_time)
                        {{ $patient->arrive_date_time }} ({{ Carbon\Carbon::parse($patient->arrive_date_time)->diffInDays(date('Y-m-d')) }} {{ __('Day(s) ago') }})
                        @endif
                    </td>
                    <td><a class="btn btn-outline-primary btn-sm" href="{{ route('patients.show',$patient->id) }}">{{ __('View patient information') }}</a></td>
                </tr>
                @empty
                <tr>
                    <td class="text-center" colspan="6">
                        <div class="alert alert-light text-muted text-center border-0 mb-0" role="alert">
                            <i class="bi bi-exclamation-square-fill h2 d-block"></i>
                            {{ __('No data found') }}
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div id="list-patients" class="d-block d-sm-none" wire:loading.class.deplay="opacity-50">
        @forelse($patients as $patient)
            <a href="{{ route('patients.show', $patient->id) }}" class="card shadow-sm mb-2 link-offset-2 link-underline link-underline-opacity-0 border-light-subtle">
                <div class="card-body d-flex align-items-top">
                    {{-- <img src="{{ $patient->customer_user ? $patient->customer_user->avatar : asset('public/images/undraw_profile.svg') }}" class="img-profile rounded-circle me-2" width="32px" height="32px"> --}}
                    <div>
                        <span class="user-request">{{ $patient->full_name }} </span>
                        <span class="text-muted">{{ $patient->health_status()->exists() ? __('Health status').' '.$patient->health_status->name : __('Patient\'s condition unknown') }} {{ __('sent into the system at') }}</span>
                        <span class="text-muted small">{{ __('sent into the system at') }}</span>
                        <span class="small">
                            {{ $patient->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0 d-flex justify-content-between">
                    <span class="badge rounded-pill p-2 fw-normal bg-success-subtle text-success">
                        <i class="bi bi-check2-circle"></i>
                        {{ __('Current stage') }} {{ $patient->stage->name }}
                    </span>
                </div>
            </a>
        @empty
            <div class="alert alert-light text-muted text-center border-0 my-5" role="alert">
                <i class="bi bi-exclamation-square-fill h2 d-block"></i>
                {{ __('No data found') }}
            </div>
        @endforelse
    </div>

    @if($patients->count() > 0)
        <div class="d-flex justify-content-between align-items-center">
            <div class="showing-result text-muted small">
                {{ __('Showing information') }} {{ $patients->firstItem() }} - {{ $patients->lastItem() }} {{ __('From total') }} {{ $patients->total() }} {{ __('Item(s)') }}
            </div>
            <div class="showing-pagination">
                {{ $patients->links() }}
            </div>
        </div>
    @endif
</div>
