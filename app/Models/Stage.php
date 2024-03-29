<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'step',
    ];

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
}
