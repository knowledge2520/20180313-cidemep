<?php

namespace Modules\Pemedic\Repositories\Cache;

use Modules\Pemedic\Repositories\PemedicRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CachePemedicDecorator extends BaseCacheDecorator implements PemedicRepository
{
    public function __construct(PemedicRepository $pemedic)
    {
        parent::__construct();
        $this->entityName = 'pemedic.pemedics';
        $this->repository = $pemedic;
    }
}
