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
use Modules\Pemedic\Repositories\GroupRepository;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

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

    /**
     * @var GroupRepository
     */
    private $groupRepository;

    public function __construct(UserProfileRepository $userProfileRepository,UserRepository $userRepository,ClinicProfileRepository $clinicRepository,MedicalRecordRepository $medicalRecordRepository,MedicalRecordFileRepository $medicalRecordFileRepository,GroupRepository $groupRepository)
    {

        $this->userProfileRepository        = $userProfileRepository;
        $this->userRepository               = $userRepository;
        $this->clinicRepository             = $clinicRepository;
        $this->medicalRecordRepository      = $medicalRecordRepository;
        $this->medicalRecordFileRepository  = $medicalRecordFileRepository;
        $this->groupRepository              = $groupRepository;
    }

    /**
     * @param array $data
     * @param $request
     */
    public function create($data = array(),$request)
    {
        $data['date'] = !empty($data['date'])?date('Y-m-d', strtotime($data['date'])):date("Y-m-d");
        if($data['patient_group'] == 1)
        {
            $medical = $this->medicalRecordRepository->create($data);
            if($medical)
            {
                if(!empty($data['file']))
                {
                    foreach ($request->file as $file) {
                        $thumbnail = $file->getClientOriginalName();
                        $path = $this->uploadFile($file,$medical);
                        $this->medicalRecordFileRepository->create([
                            'medical_id' => $medical->id,
                            'patient_id' => $medical->patient_id,
                            'path'       => $path,
                            'thumbnail'  => $thumbnail,
                        ]);
                    }
                }
            }
            return null;
        }
        else
        {
            $errors = [];
            $group = $this->groupRepository->find($request->group_id);
            $patients = $group->users;
            if(!empty($data['file']))
            {
                foreach ($request->file as $file) {
                    $thumbnail = $file->getClientOriginalName();
                    $file_name =  explode('+',$thumbnail);
                    $temp=0;
                    foreach ($patients as $patient) {
                        if($patient->email == $file_name[0])
                        {
                            $data['patient_id'] = $patient->id;
                            $medical = $this->medicalRecordRepository->create($data);
                            $path = $this->uploadFile($file,$medical);
                            $this->medicalRecordFileRepository->create([
                                'medical_id' => $medical->id,
                                'patient_id' => $medical->patient_id,
                                'path'       => $path,
                                'thumbnail'  => $thumbnail,
                            ]);
                            $temp++;
                        }
                    }
                    if($temp==0)
                    {
                        $errors[] = $thumbnail;
                    }
                }
            }
            return $errors;
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
        $data['date'] = !empty($data['date'])?date('Y-m-d', strtotime($data['date'])):date("Y-m-d");
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
        $filePath = 'public/assets/'.$medical->date.'/'.$medical->patient_id.'/'. $file->getClientOriginalName();
        $url = '/assets/'.'/'.$medical->date.'/'.$medical->patient_id.'/'. $file->getClientOriginalName();
        $result = $s3->put($filePath, file_get_contents($file),'public');
        if($result)
        {
            return $url;
        } 
    }
    
        /**
     * Author: Dung Vo
     * [getListMedicalRecords get list medical record of user]
     * @param  object  $user [item patient user]
     * @param  boolean $page [page]
     * @param  boolean $take [limit]
     * @return array         [list items vouchers]
     */
    public function getListMedicalRecords($user, $page = false, $take = false){
        return $this->medicalRecordRepository->getList('list', $user, $page, $take);
    } 

    /**
     * Author: Dung Vo
     * [getAllMedicalRecords get all medical record of patient user]
     * @param  object  $user [item patient user]
     * @return array         [list items vouchers]
     */
    public function getAllMedicalRecords($user){
        return $this->medicalRecordRepository->getAll($user);
    } 

    /**
     * [getPaginator get pagination for list item]
     * @param  object  $items       [items vouchers]
     * @param  boolean $currentPage [current page]
     * @param  boolean $perPage     [per page]
     * @return object               [items pagination]
     */
    public function getPaginator($items, $currentPage = false, $perPage = false){
        // $items = $this->repository->getAll($user);
        $total = count($items);
        $paginate = new Paginator($items, $total, $perPage, $currentPage);

        return $paginate;
    }

}