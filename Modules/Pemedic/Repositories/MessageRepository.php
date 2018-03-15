<?php

namespace Modules\Pemedic\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface MessageRepository extends BaseRepository
{
	public function pushCriteria();
	
}
