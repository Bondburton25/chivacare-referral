<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientImage extends Model
{
    use SoftDeletes;

    protected $table = 'patient_images';

    protected $fillable = [
        'image',
        'caption',
        'description',
        'patient_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
