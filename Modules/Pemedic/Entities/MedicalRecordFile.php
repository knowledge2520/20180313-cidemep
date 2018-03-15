<?php

namespace Modules\Pemedic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalRecordFile extends Model
{
    use SoftDeletes;
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
