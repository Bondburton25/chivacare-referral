<?php

namespace App\Http\Livewire\Patient;

use Livewire\Component;

use App\Models\{
    Patient,
    Stage,
    HealthStatus
};

class Form extends Component
{
    public $health_status_description, $health_status_name, $health_status_id;

    public function updatedHealthStatusId()
    {
        $health_status = HealthStatus::find($this->health_status_id);
        $this->health_status_description = $health_status->description;
        $this->health_status_name = $health_status->name;
    }

    public function render()
    {
        return view('livewire.patient.form', ['health_statuses' => HealthStatus::all()]);
    }
}
