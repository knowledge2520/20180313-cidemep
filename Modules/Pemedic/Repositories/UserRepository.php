<?php

namespace Modules\Pemedic\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface UserRepository extends BaseRepository
{
	public function showListUser($roleId,$users);
	public function addNewUser($roleId,$allRequest,$status);
	public function validateEmail($roleId,$email);
}
