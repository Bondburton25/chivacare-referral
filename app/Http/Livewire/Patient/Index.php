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

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['refreshParent' => '$refresh'];

    public $search, $byStage;

    public function render()
    {
        $stages   = Stage::all();
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
        ->idDescending()->paginate(4);
        return view('livewire.patient.index', ['patients' => $patients, 'stages' => $stages]);
    }
}
