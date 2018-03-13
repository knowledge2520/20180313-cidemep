<?php
namespace Modules\Pemedic\Http\Definitions;
/**
 * @SWG\Definition(type="object", @SWG\Xml(name="i"))
 */
class Register
{
    /**
     * @SWG\Property(example="test@test.com")
     * @var string
     */
    public $email;
    /**
     * @SWG\Property(example="name")
     * @var string
     */
    public $full_name;
    /**
     * @SWG\Property(example="841207423094")
     * @var string
     */
    public $phone;
    /**
     * @SWG\Property(example="168/6 Bùi Thị Xuân")
     * @var string
     */
    public $address;
    /**
     * @SWG\Property(example="Male")
     * @var string
     */
    public $gender;
    /**
     * @SWG\Property(example="2018-03-07")
     * @var string
     */
    public $dob;
    /**
     * @SWG\Property(example="168")
     * @var string
     */
    public $height;
    /**
     * @SWG\Property(example="61")
     * @var string
     */
    public $weight;
}