<?php

namespace Modules\Pemedic\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Pemedic extends Model
{
    use Translatable;

    protected $table = 'pemedic__pemedics';
    public $translatedAttributes = [];
    protected $fillable = [];
}
