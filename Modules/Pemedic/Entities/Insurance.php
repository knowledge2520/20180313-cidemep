<?php

namespace Modules\Pemedic\Entities;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
	protected $table = 'pemedic__issurance';
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'address',
        'map',
        'work_time',
        'website',
        'image',
        'status',
        'ordering',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}


