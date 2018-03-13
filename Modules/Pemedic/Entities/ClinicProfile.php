<?php

namespace Modules\Pemedic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClinicProfile extends Model
{
    use SoftDeletes;
    protected $table = 'pemedic__clinic_profiles';
    protected $fillable =[
        'user_id',
        'clinic_name',
        'phone',
        'vip_phone',
        'address',
        'map',
        'word_time',
        'website',
        'issurance',
        'image',
        'status',
        'ordering',
    ];

    //-----------  Relationship functions ----------- 
    public function user() {
        return $this->belongsTo('Modules\Pemedic\Entities\User', 'user_id');
    }

    
}
