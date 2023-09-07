<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    public $timestamps = false;

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
}
