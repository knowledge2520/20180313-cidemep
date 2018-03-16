<?php

namespace Modules\Pemedic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;
    protected $table = 'pemedic__groups';
    protected $fillable =[
        'clinic_id',
        'name',
        'phone',
        'address',
        'type'
    ];

    //-----------  Relationship functions ----------- 
    public function users()
    {
        return $this->belongsToMany('Modules\Pemedic\Entities\User','pemedic__patient_group','group_id','patient_id');
    }
    public function clinic()
    {
        return $this->belongsTo('Modules\Pemedic\Entities\User','clinic_id');
    }
}
