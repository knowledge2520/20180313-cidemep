<?php

namespace Modules\Pemedic\Repositories\Cache;

use Modules\Pemedic\Repositories\MedicalRecordRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheMedicalRecordDecorator extends BaseCacheDecorator implements MedicalRecordRepository
{
    public function __construct(MedicalRecordRepository $medicalRecord)
    {
        parent::__construct();
        $this->entityName = 'pemedic__medical_records';
        $this->repository = $medicalRecord;
    }
}
