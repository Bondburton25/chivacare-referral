<?php

namespace App\Http\Livewire\Patient;

use App\Models\{
    Patient,
    Stage,
    HealthStatus
};

use Livewire\{
    Component,
    WithPagination
};

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['refreshParent' => '$refresh'];

    public $search, $byStage, $byHealthStatus, $byArriveDate;

    public function render()
    {
        $stages   = Stage::all();
        $health_statuses = HealthStatus::all();

        // $date = Carbon::today()->subDays(300);
        // dd($date);
        // $date_30_days_ago = Carbon::today()->subDays(30);
        // dd($date_30_days_ago);
        // $date_30_days_ago = Carbon::now()->subDays(30);
        $patients = Patient::where('arrive_date_time', '<=', Carbon::now()->subDays(30))->paginate(10);

        // $patients = Patient::when($this->search, function($query) {
        //     $query->whereHas('referred_by', function($query) {
        //             $query->where('name', 'like', '%'.$this->search.'%');
        //         })
        //         ->orWhere('first_name', 'like', '%'.$this->search.'%')
        //         ->orWhere('last_name', 'like', '%'.$this->search.'%')
        //         ->orWhere('contact_person', 'like', '%'.$this->search.'%')
        //         ->orWhere('number', 'like', '%'.$this->search.'%')
        //         ->orWhere('phone_number', 'like', '%'.$this->search.'%');
        //     })
        //     ->when($this->byStage, function($query) {
        //         $query->where('stage_id', $this->byStage);
        //     })
        //     ->when($this->byHealthStatus, function($query) {
        //         $query->where('health_status_id', $this->byHealthStatus);
        //     })
        //     ->when($this->byArriveDate, function($query) {
        //         $query->where('arrive_date_time', '>=', $this->byArriveDate);
        //     })
        // ->where('arrive_date_time', '>', now()->subDays(30))
        // ->idDescending()
        // ->paginate(10);
        return view('livewire.patient.index', ['patients' => $patients, 'stages' => $stages, 'health_statuses' => $health_statuses]);
    }
}
