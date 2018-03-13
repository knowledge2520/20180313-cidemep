<?php

namespace Modules\Pemedic\Entities;

use Illuminate\Database\Eloquent\Model;

class MedicalRecordFile extends Model
{

    protected $table = 'pemedic__medical_record_files';
    protected $fillable = [
        'medical_id',
        'patient_id',
        'path',
        'thumbnail',
        'deleted_portal',
        'deleted_app',
        'created_at',
        'updated_at',
    ];
}
