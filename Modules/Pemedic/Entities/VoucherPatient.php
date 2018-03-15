<?php

namespace Modules\Pemedic\Entities;

use Illuminate\Database\Eloquent\Model;

class VoucherPatient extends Model
{

    protected $table = 'pemedic__voucher_patient';
    protected $guard = [];

    //-----------  Relationship functions ----------- 
    public function voucher() {
        return $this->belongsTo('Modules\Pemedic\Entities\Voucher', 'voucher_id');
    }

    public function patient() {
        return $this->belongsTo('Modules\Pemedic\Entities\User', 'patient_id');
    }
}
