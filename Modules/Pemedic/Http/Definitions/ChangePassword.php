<?php
namespace  Modules\Pemedic\Http\Definitions;
/**
 * @SWG\Definition(type="object", @SWG\Xml(name="ChangePassword"))
 */
class ChangePassword
{
     /**
     * @SWG\Property(example="admin@admin.com")
     * @var string
     */
    public $currentPassword;
    /**
     * @SWG\Property(example="admin@admin.com")
     * @var string
     */
    public $newPassword;
}