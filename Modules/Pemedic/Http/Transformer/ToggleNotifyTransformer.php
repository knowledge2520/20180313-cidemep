<?php 
namespace Modules\Pemedic\Http\Transformer;

use Logaretm\Transformers\Transformer;
class ToggleNotifyTransformer extends Transformer
{
    /**
     * @param $user
     * @return mixed
     */
    public function getTransformation($user)
    {
        return [
            'is_receive_voucher' => $user->profile ? $user->profile->is_receive_voucher : 0,
            'is_receive_news' => $user->profile ? $user->profile->is_receive_news : 0,
        ];
    }
}