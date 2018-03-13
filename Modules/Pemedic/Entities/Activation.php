<?php

namespace Modules\Pemedic\Entities;

use Illuminate\Database\Eloquent\Model;

class Activation extends Model
{

    protected $table = 'activations';
    protected $fillable = ['user_id','code','completed'];
}
