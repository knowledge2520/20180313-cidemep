<?php

namespace Modules\Pemedic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;
    protected $table = 'pemedic__message';
    protected $guarded = [];

    //-----------  Relationship functions ----------- 
    public function doctor() {
        return $this->belongsTo('Modules\Pemedic\Entities\User', 'doctor_id');
    }

    public function patient() {
        return $this->belongsTo('Modules\Pemedic\Entities\User', 'patient_id');
    }
    
}
