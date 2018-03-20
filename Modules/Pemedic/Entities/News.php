<?php

namespace Modules\Pemedic\Entities;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
	protected $table = 'pemedic__news';
    protected $fillable = [
        'title',
        'content',
        'image',
        'ordering',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    //-----------  Relationship functions ----------- 
    public function translate()
    {
        return $this->hasmany('Modules\Pemedic\Entities\NewsTranslation','new_id');
    }

}
