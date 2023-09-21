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

use Gate;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['refreshParent' => '$refresh'];

    public $search, $byStage, $byHealthStatus, $byArriveDate;

    public function render()
    {
        $stages = Stage::all();
        $health_statuses = HealthStatus::all();

        if(Gate::allows('isAdmin')) {
            $patients = Patient::when($this->search, function($query) {
                $query->whereHas('referred_by', function($query) {
                        $query->where('name', 'like', '%'.$this->search.'%');
                    })
                    ->orWhere('first_name', 'like', '%'.$this->search.'%')
                    ->orWhere('last_name', 'like', '%'.$this->search.'%')
                    ->orWhere('contact_person', 'like', '%'.$this->search.'%')
                    ->orWhere('number', 'like', '%'.$this->search.'%')
                    ->orWhere('phone_number', 'like', '%'.$this->search.'%');
                })
                ->when($this->byStage, function($query) {
                    $query->where('stage_id', $this->byStage);
                })
                ->when($this->byHealthStatus, function($query) {
                    $query->where('health_status_id', $this->byHealthStatus);
                })
            ->idDescending()
            ->paginate(10);
        } else {
        $patients = Patient::where('referred_by_id', auth()->user()->id)
                        ->when($this->search, function($query) {
                            $query->where('first_name', 'like', '%'.$this->search.'%')
                            ->orWhere('last_name', 'like', '%'.$this->search.'%')
                            ->orWhere('contact_person', 'like', '%'.$this->search.'%')
                            ->orWhere('number', 'like', '%'.$this->search.'%')
                            ->orWhere('phone_number', 'like', '%'.$this->search.'%');
                        })
                        ->when($this->byStage, function($query) {
                            $query->where('stage_id', $this->byStage);
                        })
                        ->when($this->byHealthStatus, function($query) {
                            $query->where('health_status_id', $this->byHealthStatus);
                        })
                    ->idDescending()
                    ->paginate(10);
        }
        return view('livewire.patient.index', ['patients' => $patients, 'stages' => $stages, 'health_statuses' => $health_statuses]);
    }
}
