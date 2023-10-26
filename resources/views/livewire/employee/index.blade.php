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
</div>
