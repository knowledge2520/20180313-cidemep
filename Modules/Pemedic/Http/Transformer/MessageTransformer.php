<?php 
namespace Modules\Pemedic\Http\Transformer;

use Logaretm\Transformers\Transformer;
class MessageTransformer extends Transformer
{
    /**
     * @param $user
     * @return mixed
     */
    public function getTransformation($message)
    {
        return [
            'id' => $message->id,
            'doctor' => $message->doctor ? ($message->doctor->profile ? $message->doctor->profile->full_name : "") : "",
            'message' => $message->message,
            'is_read' => $message->is_read_patient,
            'created_at' => \Carbon\Carbon::parse($message->created_at)->format('d/m/Y H:i:s'),

        ];
    }
}