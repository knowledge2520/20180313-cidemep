<?php

namespace Modules\Pemedic\Repositories\Cache;

use Modules\Pemedic\Repositories\InsuranceRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheInsuranceDecorator extends BaseCacheDecorator implements InsuranceRepository
{
    public function __construct(InsuranceRepository $insurance)
    {
        parent::__construct();
        $this->entityName = 'pemedic__issurance';
        $this->repository = $insurance;
    }
}
