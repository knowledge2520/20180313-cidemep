<?php
namespace  Modules\Pemedic\Http\Definitions;
/**
 * @SWG\Definition(type="object", @SWG\Xml(name="ForgotPassword"))
 */
class ForgotPassword
{
    /**
     * @SWG\Property(example="admin@admin.com")
     * @var string
     */
    public $email;
}