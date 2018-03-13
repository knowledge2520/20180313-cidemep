<?php

namespace Modules\Pemedic\Entities;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{

    protected $table = 'pemedic__medical_records';
    protected $fillable = [
        'clinic_id',
        'title',
        'patient_id',
        'doctor_id',
        'doctor_name',
        'clinic_name',
        'date',
        'type',
        'ordering',
        'created_at',
        'updated_at',
    ];
}
