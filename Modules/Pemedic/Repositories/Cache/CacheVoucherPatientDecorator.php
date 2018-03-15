<?php

namespace Modules\Pemedic\Repositories\Cache;

use Modules\Pemedic\Repositories\VoucherPatientRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheVoucherPatientDecorator extends BaseCacheDecorator implements VoucherPatientRepository
{
    public function __construct(VoucherPatientRepository $voucherpatient)
    {
        parent::__construct();
        $this->entityName = 'pemedic__voucher_patient';
        $this->repository = $voucherpatient;
    }
}
