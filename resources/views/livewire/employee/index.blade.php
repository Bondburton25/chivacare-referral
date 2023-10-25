<div>
    <div class="table-responsive d-none d-sm-block">
        <table class="table table-striped align-middle caption-top mb-0">
            <tbody>
            <tr>
                <td class="fw-normal">{{ __('Name') }}</td>
                <td class="fw-normal">{{ __('Role') }}</td>
                <td class="fw-normal">{{ __('Phone number') }}</td>
                <td class="fw-normal">{{ __('Affiliation') }}</td>
                <td class="fw-normal">{{ __('Registered at') }}</td>
                <td class="fw-normal">{{ __('Verified at') }}</td>
                <td class="fw-normal">{{ __('Action') }}</td>
            </tr>
                @forelse($employees as $employee)
                    <tr wire:loading.class.deplay="opacity-50">
                        <td>{{ $employee->fullname }}</td>
                        <td>{{ __($employee->role) }}</td>
                        <td>{{ $employee->phone_number }}</td>
                        <td>{{ $employee->affiliation }}</td>
                        <td>{{ $employee->created_at }}</td>
                        <td>{{ $employee->verified_at ? $employee->verified_at : '' }}</td>
                        <td>
                            <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-success btn-sm">
                                {{ __('View profile') }}
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="text-center" colspan="7">
                            <div class="alert alert-light text-muted text-center border-0" role="alert">
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
        @forelse($employees as $employee)
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <a href="{{ route('employees.show', $employee->id) }}" class="d-flex align-items-center text-reset text-decoration-none">
                    <div class="flex-shrink-0">
                        <img src="{{ $employee->avatar }}" class="img-profile rounded-circle me-1">
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <span class="text-primary">{{ $employee->fullname }}</span>
                        <br>
                        {{ __('has registered as an employee') }}
                        <span class="text-success">{{ __('Role') }} {{ __($employee->role) }}</span>
                    </div>
                </a>
            </div>
        </div>
        @empty
            <div class="alert alert-light text-muted text-center border-0 my-5" role="alert">
                <i class="bi bi-exclamation-square-fill h2 d-block"></i>
                {{ __('No data found') }}
            </div>
        @endforelse
    </div>
</div>
