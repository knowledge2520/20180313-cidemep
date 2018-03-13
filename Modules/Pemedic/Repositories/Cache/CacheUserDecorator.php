<?php

namespace Modules\Pemedic\Repositories\Cache;

use Modules\Pemedic\Repositories\UserRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheUserDecorator extends BaseCacheDecorator implements UserRepository
{
    public function __construct(UserRepository $user)
    {
        parent::__construct();
        $this->entityName = 'users';
        $this->repository = $user;
    }
}
