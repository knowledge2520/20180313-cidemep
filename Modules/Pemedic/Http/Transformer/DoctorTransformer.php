<?php 
namespace Modules\Pemedic\Http\Transformer;

use Logaretm\Transformers\Transformer;
class DoctorTransformer extends Transformer
{
    /**
     * @param $user
     * @return mixed
     */
    public function getTransformation($user)
    {
        return [
            'id' => $user->id,
            'name' => $user->profile ? $user->profile->full_name : "",
        ];
    }
}