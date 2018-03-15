<?php

namespace Modules\Pemedic\Repositories\Cache;

use Modules\Pemedic\Repositories\NewsRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheNewsDecorator extends BaseCacheDecorator implements NewsRepository
{
    public function __construct(NewsRepository $news)
    {
        parent::__construct();
        $this->entityName = 'pemedic__news';
        $this->repository = $news;
    }
}
