<?php

namespace Modules\Pemedic\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface UserProfileRepository extends BaseRepository
{
	public function items($role_id);
	public function filterClinic($role_id,$clinic_id);
}
