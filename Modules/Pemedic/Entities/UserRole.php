<?php

namespace Modules\Pemedic\Entities;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{

    protected $table = 'role_users';
    protected $fillable = [
        'user_id',
        'role_id',
        'created_at',
        'updated_at',
    ];
}
