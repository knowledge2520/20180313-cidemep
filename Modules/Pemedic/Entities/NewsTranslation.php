<?php

namespace Modules\Pemedic\Entities;

use Illuminate\Database\Eloquent\Model;

class NewsTranslation extends Model
{
	protected $table = 'pemedic__news_translations';
    protected $fillable = [
        'id',
        'new_id',
        'locale',
        'status',
        'content',
        'image',
        'image_thumb',
        'title',
        'created_at',
        'updated_at'
    ];
}
