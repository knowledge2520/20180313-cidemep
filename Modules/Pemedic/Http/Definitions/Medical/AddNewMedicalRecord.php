<?php
namespace  Modules\Pemedic\Http\Definitions\Medical;
/**
 * @SWG\Definition(type="object", @SWG\Xml(name="AddNewMedicalRecord"))
 */
class AddNewMedicalRecord
{
     /**
     * @SWG\Property(example="2018-03-08")
     * @var string
     */
    public $date;
    /**
     * @SWG\Property(example="Phước An")
     * @var string
     */
    public $clinic_name;
    /**
     * @SWG\Property(example="Phước An")
     * @var string
     */
    public $doctor_name;
}