<?php

namespace App\Http\Livewire\ReferralFee;

use App\Models\{
    Patient,
    User
};

use Livewire\{
    Component,
    WithPagination
};

use Illuminate\Database\Eloquent\Builder;
use Gate;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['refreshParent' => '$refresh'];

    public $referredBy;

    public function render()
    {
        $referrers = User::whereHas('patients', function (Builder $query) {
            $query->where('arrive_date_time', '<=', Carbon::now()->subDays(30));
        })->get();

        if(Gate::allows('isAdmin')) {
            $patients = Patient::whereHas('stage', function (Builder $query) {
                $query->whereIn('step', [6,7,8]);
            })
            ->when($this->referredBy, function($query) {
                $query->where('referred_by_id', $this->referredBy);
            })
            ->idDescending()
            ->paginate(10);
        } else {
            $patients = Patient::whereHas('stage', function (Builder $query) {
                $query->whereIn('step', [6,7,8]);
            })
            ->where('referred_by_id', auth()->user()->id)
            ->idDescending()
            ->paginate(10);
        }
        return view('livewire.referral-fee.index', ['patients' => $patients, 'referrers' => $referrers]);
    }
}
