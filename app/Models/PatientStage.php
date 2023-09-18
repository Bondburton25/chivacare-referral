<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientStage extends Model
{
    protected $fillable = [
        'patient_id',
        'stage_id',
        'actioned_by_id',
        'created_at',
    ];

    public $timestamps = ['created_at'];

    const UPDATED_AT = null;

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function actioned_by()
    {
        return $this->belongsTo(User::class, 'actioned_by_id');
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model) {
            $model->actioned_by_id = auth()->id();
        });
    }
}
