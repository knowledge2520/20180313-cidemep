<?php

namespace Modules\Pemedic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model
{
    use SoftDeletes;
    protected $table = 'pemedic__user_profiles';
    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'address',
        'gender',
        'dob',
        'height',
        'weight',
        'type',
        'image',
        'other_info',
        'is_receive_voucher',
        'is_receive_news',
        'is_support',
        'status',
        'ordering',
        'deleted_portal',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo('Modules\Pemedic\Entities\User');
    }
}
