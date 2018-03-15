<?php

namespace Modules\Pemedic\Repositories\Cache;

use Modules\Pemedic\Repositories\NewRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheNewDecorator extends BaseCacheDecorator implements NewRepository
{
    public function __construct(NewRepository $new)
    {
        parent::__construct();
        $this->entityName = 'pemedic__news';
        $this->repository = $new;
    }
}
