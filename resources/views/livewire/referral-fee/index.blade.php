<div>
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
    <div class="table-responsive-sm">
        <table class="table">
            <tr>
                <td>{{ __('Patient') }}</td>
                @can('isAdmin')
                <td>{{ __('Referred by') }}</td>
                @endcan
                <td>{{ __('Current stage') }}</td>
                <td>{{ __('Number of service days') }}</td>
                <td>{{ __('Referral fee to be paid') }}</td>
            </tr>
            @forelse ($patients as $patient)
                <tr wire:loading.class.deplay="opacity-50">
                    <td>{{ $patient->fullname }}</td>
                    @can('isAdmin')
                    <td>{{ $patient->referred_by->fullname }}</td>
                    @endcan
                    <td>
                        <span class="badge rounded-pill p-2 fw-normal bg-success-subtle text-success">
                            <i class="bi bi-check2-circle"></i>
                            {{ __('Step') }} {{ $patient->stage->step }} {{ $patient->stage->name }}
                        </span>
                    </td>
                    <td>{{ Carbon\Carbon::parse($patient->arrive_date_time)->diffInDays(date('Y-m-d'))+1 }} {{ __('Days') }}</td>
                    <td>{{ $patient->stage->step == 8 ? number_format(1500,2) : number_format(1000,2) }}</td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="5">
                        <div class="alert alert-light text-muted text-center border-0 mb-0" role="alert">
                            <i class="bi bi-exclamation-square-fill h2 d-block"></i>
                            {{ __('No data found') }}
                        </div>
                    </td>
                </tr>
            @endforelse
        </table>
    </div>
</div>
