<?php

namespace Modules\Pemedic\Entities;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{

    protected $table = 'pemedic__vouchers';
    protected $guard = [];

    //-----------  Relationship functions ----------- 
    public function voucherPatient() {
        return $this->HasOne('Modules\Pemedic\Entities\VoucherPatient', 'voucher_id');
    }

    public function clinic() {
        return $this->belongsTo('Modules\Pemedic\Entities\ClinicProfile', 'clinic_id');
    }
}
