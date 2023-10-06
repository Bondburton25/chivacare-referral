<div>
    <div class="d-block text-muted mb-2" id="filter">
        <i class="bi bi-funnel-fill"></i> {{ __('Filter information by') }}:
    </div>
    <div class="row mb-3">
        <div class="col-sm-3 col-12 mb-3">
            <input type="text" wire:model="search" class="form-control form-control-sm" placeholder="{{ __('Search patients') }} {{ __('By name, Refer no, contact person') }}...">
        </div>

        <div class="col-sm-3 col-6 mb-2">
            <div class="mb-2">
                <select wire:model="byStage" class="form-control form-control-sm">
                    <option value="" selected>{{ __('Show all stage') }}</option>
                    @foreach($stages as $stage)
                        <option value="{{ $stage->id }}">{{ __('Step') }} {{ $stage->step }} {{ $stage->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-sm-3 col-6 mb-2">
            <select wire:model="byHealthStatus" class="form-control form-control-sm">
                <option value="" selected>{{ __('Show all health status') }}</option>
                @foreach ($health_statuses as $health_status)
                    <option value="{{ $health_status->id }}">{{ $health_status->name }}</option>
                @endforeach
            </select>
        </div>

        @can('isAdmin')
        <div class="col-sm-3 col-6 mb-2">
            <select wire:model="referredBy" class="form-control form-control-sm">
                <option value="" selected>{{ __('Shows patients referred by everyone') }}</option>
                @foreach ($referrers as $referrer)
                    <option value="{{ $referrer->id }}">{{ __('Referred by') }} {{ __($referrer->role) }} {{ $referrer->fullname }}</option>
                @endforeach
            </select>
        </div>
        @endcan

        <div class="col-sm-3 col-6 mb-2">
            <select wire:model="byRoomType" class="form-control form-control-sm">
                <option value="" selected>{{ __('Show all room types') }}</option>
                <option value="single">{{ __('Single room') }}</option>
                <option value="sharing">{{ __('Shared room') }}</option>
                <option value="">{{ __('Don\'t know yet') }}</option>
            </select>
        </div>

    </div>
    <div class="table-responsive d-none d-sm-block">
        <table class="table table-striped align-middle caption-top">
            <caption class="text-muted">
                <small>{{ __('Total found') }} {{ $patients->total() }} {{ __('Item(s)') }} </small>
            </caption>
            <tbody>
                <tr>
                    <td>{{ __('Refer number') }}</td>
                    <td>{{ __('Name') }}-{{ __('Last name') }} </td>
                    <td>{{ __('Stage') }}</td>
                    <td>{{ __('Health status') }}</td>
                    <td>{{ __('Arrival date') }}</td>
                    @can('isAdmin')
                    <td>{{ __('Referred by') }}</td>
                    @endcan
                    <td>{{ __('Action') }}</td>
                </tr>
                @forelse($patients as $patient)
                <tr wire:loading.class.deplay="opacity-50">
                    <td>{{ $patient->number }}</td>
                    <td>{{ $patient->full_name }}</td>
                    <td>
                        <span class="badge rounded-pill p-2 fw-normal bg-success-subtle text-success">
                            <i class="bi bi-check2-circle"></i>
                            {{ __('Step') }} {{ $patient->stage->step }} {{ $patient->stage->name }}
                        </span>
                    </td>
                    <td>{{ $patient->health_status()->exists() ? __('Health status').' '.$patient->health_status->name : __('Patient\'s condition unknown') }}</td>
                    <td class="text-{{ $patient->arrive_date_time ? '' : 'muted' }}">
                        @if($patient->arrive_date_time)
                            {{ $patient->arrive_date_time }}
                            ({{ Carbon\Carbon::parse($patient->arrive_date_time)->diffInDays(date('Y-m-d'))+1 }} {{ __('Day(s) ago') }})
                        @else
                            {{ __('Not staying yet') }}
                        @endif
                    </td>
                    @can('isAdmin')
                    <td>
                        <img src="{{ $patient->referred_by->avatar }}" class="img-profile rounded-circle mr-5">
                        {{ __($patient->referred_by->role) }} {{ $patient->referred_by->fullname }}
                    </td>
                    @endcan
                    <td><a class="btn btn-outline-primary btn-sm" href="{{ route('patients.show',$patient->id) }}">{{ __('View patient information') }}</a></td>
                </tr>
                @empty
                <tr>
                    <td class="text-center" colspan="7">
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
                    <div class="info text-muted">
                        @can('isAdmin')
                        <img src="{{ $patient->referred_by->avatar }}" class="img-profile rounded-circle me-1">{{ __($patient->referred_by->role) }}
                        <span class="text-primary">{{ $patient->referred_by->fullname }}</span>
                            {{ __('has sent patient information named') }}
                        @else
                            {{ __('You have sent patient information named') }}
                        @endcan
                        <span class="user-request text-success">{{ $patient->full_name }}</span>
                        <span class="text-muted"> ({{ __('Refer number') }} </span>
                        <span class="text-success">{{ $patient->number }})</span>

                        <div class="d-block">
                            {{ $patient->health_status()->exists() ? __('Health status').' '.$patient->health_status->name : __('Patient\'s condition unknown') }} {{ __('sent into the system at') }} {{ $patient->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0 d-flex justify-content-between">
                    <span class="badge rounded-pill p-2 fw-normal bg-success-subtle text-success">
                        <i class="bi bi-check2-circle"></i>
                        {{ __('Current stage') }} {{ __('In stage') }} {{ $patient->stage->step }} {{ $patient->stage->name }}
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
