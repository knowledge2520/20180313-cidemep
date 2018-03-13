<?php

namespace Modules\Pemedic\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface ClinicProfileRepository extends BaseRepository
{
	public function createUser($data);
	public function activateUser($user);
}
