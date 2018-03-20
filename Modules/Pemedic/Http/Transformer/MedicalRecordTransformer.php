<?php 
namespace Modules\Pemedic\Http\Transformer;

use Logaretm\Transformers\Transformer;
use Modules\Pemedic\Http\Transformer\MedicalRecordFileTransformer;
class MedicalRecordTransformer extends Transformer
{
    /**
     * @param $user
     * @return mixed
     */
    public function getTransformation($item)
    {
        $fileTransformer = new MedicalRecordFileTransformer();

        return [
            'id' => $item->id,
            'title'=> $item->title ? $item->title : "",
            'date'=> \Carbon\Carbon::parse($item->date)->format('d/m/Y'),
            'doctor'=> isset($item->doctor) && !empty($item->doctor) ? ($item->doctor->profile->full_name ? $item->doctor->profile->full_name : "") : "abc",
            'clinic'=> isset($item->clinic) && !empty($item->clinic) ? ($item->clinic->clinicProfile->clinic_name ? $item->clinic->clinicProfile->clinic_name : "") : "CLinic Name",
            'fileThumbnails' => $fileTransformer->transform($item->file),
        ];
    }
}