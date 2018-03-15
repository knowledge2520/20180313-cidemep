<?php

namespace Modules\Pemedic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalRecord extends Model
{
    use SoftDeletes;
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

    //-----------  Relationship functions ----------- 
    public function file() {
        return $this->hasMany('Modules\Pemedic\Entities\MedicalRecordFile', 'medical_id');
    }

    public function clinic() {
        return $this->belongsTo('Modules\Pemedic\Entities\User', 'clinic_id');
    }

    public function patient() {
        return $this->belongsTo('Modules\Pemedic\Entities\User', 'patient_id','id');
    }

    public function doctor() {
        return $this->belongsTo('Modules\Pemedic\Entities\User', 'doctor_id');
    }
}
