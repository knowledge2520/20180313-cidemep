<?php

namespace Modules\Pemedic\Entities;

use Illuminate\Database\Eloquent\Model;

class PemedicTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'pemedic__pemedic_translations';
}
