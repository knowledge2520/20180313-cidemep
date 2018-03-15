<?php
/**
 * @description: Deal Service class execute the service logic CMS
 */
namespace Modules\Pemedic\Services;

use Modules\Pemedic\Repositories\UserRepository;
use Modules\Pemedic\Repositories\UserProfileRepository;
use Modules\Pemedic\Repositories\ClinicProfileRepository;
use Modules\Pemedic\Repositories\MedicalRecordRepository;
use Modules\Pemedic\Repositories\MedicalRecordFileRepository;
use Modules\Pemedic\Entities\MedicalRecord;

class MedicalService {

    /**
     * @var UserProfileRepository
     */
    private $userProfileRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var ClinicProfileRepository
     */
    private $clinicRepository;

    /**
     * @var MedicalRecordRepository
     */
    private $medicalRecordRepository;

    /**
     * @var MedicalRecordFileRepository
     */
    private $medicalRecordFileRepository;

    public function __construct(UserProfileRepository $userProfileRepository,UserRepository $userRepository,ClinicProfileRepository $clinicRepository,MedicalRecordRepository $medicalRecordRepository,MedicalRecordFileRepository $medicalRecordFileRepository)
    {

        $this->userProfileRepository        = $userProfileRepository;
        $this->userRepository               = $userRepository;
        $this->clinicRepository             = $clinicRepository;
        $this->medicalRecordRepository      = $medicalRecordRepository;
        $this->medicalRecordFileRepository  = $medicalRecordFileRepository;
    }

    /**
     * @param array $data
     * @param $request
     */
    public function create($data = array(),$request)
    {
        $data['date'] = !empty($data['date'])?date('Y-m-d', strtotime($data['date'])):null;
        $medical = $this->medicalRecordRepository->create($data);
        if($medical)
        {
            if(!empty($data['file']))
            {
                foreach ($request->file as $file) {
                    $thumbnail = $file->getClientOriginalName();
                    $file = $this->uploadFile($file,$medical);
                    $this->medicalRecordFileRepository->create([
                        'medical_id' => $medical->id,
                        'patient_id' => $medical->patient_id,
                        'path'       => $file,
                        'thumbnail'  => $thumbnail,
                    ]);
                }
            }
        }
    }

    /**
     * @param MedicalRecord
     * @param array $data
     * @param $request
     * @return null / MedicalRecord object
     */
    public function update(MedicalRecord $medical,$data = array(),$request)
    {
        $data['date'] = !empty($data['date'])?date('Y-m-d', strtotime($data['date'])):null;
        $this->medicalRecordRepository->update($medical,$data);
        if(!empty($data['file']))
        {
            foreach ($request->file as $file) {
                $thumbnail = $file->getClientOriginalName();
                $file = $this->uploadFile($file,$medical);
                $this->medicalRecordFileRepository->create([
                    'medical_id' => $medical->id,
                    'patient_id' => $medical->patient_id,
                    'path'       => $file,
                    'thumbnail'  => $thumbnail,
                ]);
            }
        }
        return $medical;
    }

    /**
     * @param $file_id
     * @return null / medical object
     */
    public function deleteFile($file_id)
    {
        $medicalFile = $this->medicalRecordFileRepository->find($file_id);
        $this->medicalRecordFileRepository->destroy($medicalFile);
    }

    /**
     * bulk delete service
     * @param $medical_id
     * @return null / medical object
     */
    public function bulkDelete($medical_id)
    {
        $medicals =  explode(',',$medical_id);
        foreach ($medicals as $id) {
            $medical = $this->medicalRecordRepository->find($id);
            if($medical)
            {
                $this->medicalRecordRepository->destroy($medical);
            }
        }  
    }


    /**
     * upload file medical function 
     * @param $file
     * @param $medical
     * @return file $url
     */
    protected function uploadFile($file,$medical)
    {
        $s3 = \Storage::disk('local');
        $time = time();
        $filePath = 'public/assets/' .$medical->clinic_id.'/'.$medical->date.'/'.$medical->patient_id.'/'. $file->getClientOriginalName();
        $url = '/assets/'.$medical->clinic_id.'/'.$medical->date.'/'.$medical->patient_id.'/'. $file->getClientOriginalName();
        $result = $s3->put($filePath, file_get_contents($file),'public');
        if($result)
        {
            return $url;
        } 
    }
    
}