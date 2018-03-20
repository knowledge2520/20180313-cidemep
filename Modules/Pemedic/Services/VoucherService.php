<?php
/**
 * @description: Deal Service class execute the service logic CMS
 */
namespace Modules\Pemedic\Services;

use Modules\Pemedic\Repositories\ClinicProfileRepository;
use Modules\User\Repositories\UserRepository;
use Modules\Pemedic\Repositories\VoucherRepository;
use Modules\Pemedic\Entities\Voucher;
use Modules\Pemedic\Repositories\VoucherPatientRepository;
use Modules\Pemedic\Repositories\UserRepository as PatientRepository;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class VoucherService {

    /**
     * @var ClinicProfileRepository
     */
    private $clinicRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

     /**
     * @var VoucherRepository
     */
    private $voucherRepository;

    /**
     * @var VoucherPatientRepository
     */
    private $voucherPatientRepository;

    /**
     * @var PatientRepository
     */
    private $patientRepository;

    public function __construct(ClinicProfileRepository $clinicRepository,UserRepository $userRepository,VoucherRepository $voucherRepository, VoucherPatientRepository $voucherPatientRepository, PatientRepository $patientRepository) {
        $this->clinicRepository         = $clinicRepository;
        $this->userRepository           = $userRepository;
        $this->voucherRepository        = $voucherRepository;
        $this->voucherPatientRepository = $voucherPatientRepository;
        $this->patientRepository        = $patientRepository;
    }


    /**
     * create voucher function
     * @param array $data
     * @return null / voucher object
     */
    public function create($data = array(),$request)
    {
        $data['image'] = null;
        $data['start_date'] = !empty($data['start_date'])?date('Y-m-d', strtotime($data['start_date'])):null;
        $data['expiry_date'] = !empty($data['expiry_date'])?date('Y-m-d', strtotime($data['expiry_date'])):null;
        if(!empty($request->file('image')))
        {
            $file = $request->file('image');
            $data['image'] = $this->uploadFile($request->file('image'));
        }
        // create clinicProfile
        return $this->voucherRepository->create([
            'clinic_id'     => $data['clinic_id'],
            'name'          => $data['name'],
            'start_date'    => $data['start_date'],
            'expiry_date'   => $data['expiry_date'],
            'image'         => $data['image'],
            'image_thumb'   => $data['image'],
        ]);
    }

    /**
     * update voucher function 
     * @param Voucher $voucher
     * @param array $data
     * @param request
     * @return null / voucher object
     */
    public function update(Voucher $voucher,$data = array(),$request)
    {     
        $data['start_date'] = !empty($data['start_date'])?date('Y-m-d', strtotime($data['start_date'])):null;
        $data['expiry_date'] = !empty($data['expiry_date'])?date('Y-m-d', strtotime($data['expiry_date'])):null;
        if(!empty($request->file('image')))
        {
            $file = $request->file('image');
            $data['image'] = $this->uploadFile($request->file('image'));
            $data['image_thumb'] = $data['image'];
        }
        return $this->voucherRepository->update($voucher,$data);
    }

    /**
     * delete image function 
     * @param array $data
     * @return null / clinic object
     */
    public function deleteImage($clinic_id)
    {
        $voucher = $this->voucherRepository->find($clinic_id);
        $voucher->image = null;
        $voucher->image_thumb = null;
        $voucher->save();
    }

    /**
     * add/remove patient
     * @param request
     */
    public function addPatient($request)
    {
        $voucher = $this->voucherRepository->find($request->voucher_id);
        if($voucher)
        {
            if($request->type == 1)
            {
                $voucher->users()->attach($request->patient_id);
            }
            else
            {
                 $voucher->users()->detach($request->patient_id);
            }
        }
    }

    protected function uploadFile($file)
    {
        $s3 = \Storage::disk('local');
        $time = time();
        $filePath = 'public/assets/voucher/' .$time.'-'. $file->getClientOriginalName();
        $url = '/assets/voucher/' .$time.'-'. $file->getClientOriginalName();
        $result = $s3->put($filePath, file_get_contents($file),'public');
        if($result)
        {
            return $url;
        } 
    }
    
    /**
     * Author: Dung Vo
     * [getListVouchers get list vouchers of user]
     * @param  object  $user [item patient user]
     * @param  boolean $page [page]
     * @param  boolean $take [limit]
     * @return array         [list items vouchers]
     */
    public function getListVouchers($user, $page = false, $take = false){
        return $this->voucherRepository->getList('list', $user, $page, $take);
    } 

    /**
     * Author: Dung Vo
     * [getAllVouchers get all voucher of patient user]
     * @param  object  $user [item patient user]
     * @return array         [list items vouchers]
     */
    public function getAllVouchers($user){
        return $this->voucherRepository->getAll($user);
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

    /**
     * Author: Dung Vo
     * [getToggleNotify switch notification setting for voucher of patient user]
     * @param  object $user [user]
     * @return object       [item user]
     */
    public function getToggleNotify($user){
        $dataUser = $this->patientRepository->find($user->id);
        $newStatus = $dataUser->profile->is_receive_voucher ? 0 : 1;
        $dataUser->profile->update(['is_receive_voucher' => $newStatus]);

        return $dataUser;
    }

    /**
     * Author: Dung Vo
     * [deleteVoucher delete voucher]
     * @param  number $id [id of voucher]
     * @return boolean    
     */
    public function deleteVoucher($id){
        $voucherPatient = $this->voucherPatientRepository->find($id);
        if(count($voucherPatient)){
            $voucherPatient->delete();
            return true;
        }

        return false;
    }

    /**
     * Author: Dung Vo
     * [findVoucherPatient find vouncher of patient user]
     * @param  number $id   [id of voucher]
     * @param  object $user [item patient user]
     * @return array        [items voucher of patient user]
     */
    public function findVoucherPatient($id, $user){
        return $this->voucherPatientRepository->findByAttributes(['id' => $id, 'patient_id' => $user->id]);
    }
}