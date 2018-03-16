<?php

namespace Modules\Pemedic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use SoftDeletes;
    protected $table = 'pemedic__vouchers';
    protected $fillable =[
        'clinic_id',
        'name',
        'start_date',
        'expiry_date',
        'image',
        'image_thumb',
        'description'
    ];

    //-----------  Relationship functions ----------- 
    public function users()
    {
        return $this->belongsToMany('Modules\Pemedic\Entities\User','pemedic__voucher_patient','voucher_id','patient_id');
    }
    public function clinic()
    {
        return $this->belongsTo('Modules\Pemedic\Entities\User','clinic_id');
    }
}
