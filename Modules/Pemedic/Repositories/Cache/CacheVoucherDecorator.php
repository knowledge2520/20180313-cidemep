<?php

namespace Modules\Pemedic\Repositories\Cache;

use Modules\Pemedic\Repositories\VoucherRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheVoucherDecorator extends BaseCacheDecorator implements VoucherRepository
{
    public function __construct(VoucherRepository $voucher)
    {
        parent::__construct();
        $this->entityName = 'pemedic__vouchers';
        $this->repository = $voucher;
    }
}
