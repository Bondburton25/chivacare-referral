<?php

namespace App\Models;

use App\Models\{
    Patient,
    Stage,
};

use Illuminate\Database\Eloquent\Model;

class HealthStatus extends Model
{
    public $timestamps = false;

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
}
