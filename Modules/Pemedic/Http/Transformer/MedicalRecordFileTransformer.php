<?php 
namespace Modules\Pemedic\Http\Transformer;

use Logaretm\Transformers\Transformer;
class MedicalRecordFileTransformer extends Transformer
{
    /**
     * @param $user
     * @return mixed
     */
    public function getTransformation($item)
    {
        return [
            'id' => $item->id,
            'path'=> \URL::to($item->path),
            'type'=> "image"
        ];
    }
}