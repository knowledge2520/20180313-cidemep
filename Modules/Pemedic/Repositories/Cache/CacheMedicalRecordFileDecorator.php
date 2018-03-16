<?php

namespace Modules\Pemedic\Repositories\Cache;

use Modules\Pemedic\Repositories\MedicalRecordFileRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheMedicalRecordFileDecorator extends BaseCacheDecorator implements MedicalRecordFileRepository
{
    public function __construct(MedicalRecordFileRepository $medicalRecordFile)
    {
        parent::__construct();
        $this->entityName = 'pemedic__medical_record_files';
        $this->repository = $medicalRecordFile;
    }
}
