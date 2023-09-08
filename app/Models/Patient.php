<?php

namespace App\Models;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $appends = ['fullname'];

    protected $fillable = [
        'number',
        'first_name',
        'last_name',
        'avatar',
        'gender',
        'birth_date',
        'weight',
        'height',
        'preliminary_symptoms',
        'food',
        'excretory_system',
        'expectations',
        'contact_person',
        'contact_person_relationship',
        'congenital_disease',
        'phone_number',
        'expected_arrive',
        'room_type',
        'offer_courses',
        'referred_by_id',
        'stage_id',
        'user_id',
        'precautions',
        'recommend_service',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the Patient's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' '. $this->last_name;
    }

    /**
     * Accessor for Age.
     */
    public function age()
    {
        return Carbon::parse($this->attributes['birth_date'])->age;
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function referred_by()
    {
    	return $this->belongsTo(User::class, 'referred_by_id');
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function scopeIdDescending($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model) {
            $first_stage = Stage::where('step', 1)->first();
            $model->stage_id = $first_stage->id;
            $model->number = 'HN'.sprintf('%05d', Patient::count()+1);
            if(auth()->check()) {
                $model->referred_by_id = auth()->id();
            }
        });
    }
}
