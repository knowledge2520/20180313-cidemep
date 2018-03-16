<?php

namespace Modules\Pemedic\Repositories\Cache;

use Modules\Pemedic\Repositories\GroupRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheGroupDecorator extends BaseCacheDecorator implements GroupRepository
{
    public function __construct(GroupRepository $group)
    {
        parent::__construct();
        $this->entityName = 'pemedic__groups';
        $this->repository = $group;
    }
}
