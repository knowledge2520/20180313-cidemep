<?php 
namespace Modules\Pemedic\Http\Transformer;

use Logaretm\Transformers\Transformer;
class UserTransformer extends Transformer
{
    /**
     * @param $user
     * @return mixed
     */
    public function getTransformation($user)
    {
        return [
            'id' => $user->id,
            'email' => $user->email,
            'phone' => $user->profile ? $user->profile->phone : "",
            'dob' => $user->profile ? \Carbon\Carbon::parse($user->profile->dob)->format('d/m/Y') : "",
            'gender' => $user->profile ? $user->profile->gender : "",
            'height' => $user->profile ? $user->profile->height : "",
            'weight' => $user->profile ? $user->profile->weight : "",
            'other_info' => $user->profile ? ($user->profile->other_info ? $user->profile->other_info : "") : "",
        ];
    }
}