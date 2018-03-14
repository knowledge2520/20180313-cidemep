<?php
namespace  Modules\Pemedic\Http\Definitions;
/**
 * @SWG\Definition(type="object", @SWG\Xml(name="NewMessage"))
 */
class NewMessage
{
    /**
     * @SWG\Property(format="int64",example="2")
     * @var string
     */
    public $doctor_id;
    /**
     * @SWG\Property(format="int64",example="content")
     * @var string
     */
    public $message;
    
}