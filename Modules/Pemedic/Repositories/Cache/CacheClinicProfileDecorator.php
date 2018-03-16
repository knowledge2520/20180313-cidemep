<?php

namespace Modules\Pemedic\Repositories\Cache;

use Modules\Pemedic\Repositories\ClinicProfileRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheClinicProfileDecorator extends BaseCacheDecorator implements ClinicProfileRepository
{
    public function __construct(ClinicProfileRepository $clinic)
    {
        parent::__construct();
        $this->entityName = 'pemedic__clinic_profiles';
        $this->repository = $clinic;
    }
}
