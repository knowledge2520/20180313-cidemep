<?php 
namespace Modules\Pemedic\Service;

use Log;
use Modules\Pemedic\Repositories\MedicalRecordRepository;
class MedicalRecordService
{
    /**
     * @var MedicalRecordRepository
     */
    private $medicalRecordRepository;

    
    public function __construct(MedicalRecordRepository $medicalRecordRepository)
    {
        $this->medicalRecordRepository = $medicalRecordRepository;
    }   

    public function addNewManualMedicalRecord()
    {
    	
    }
    
}