<?php
namespace  Modules\Pemedic\Http\Definitions;
/**
 * @SWG\Definition(type="object", @SWG\Xml(name="Login"))
 */
class Login
{
    /**
     * @SWG\Property(example="admin@admin.com")
     * @var string
     */
    public $email;
    /**
     * @SWG\Property(format="int64",example="123456")
     * @var string
     */
    public $password;
    
}