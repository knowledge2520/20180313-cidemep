<?php 
namespace Modules\Pemedic\Services;

use Modules\Pemedic\Repositories\VoucherRepository;
use Modules\Pemedic\Repositories\VoucherPatientRepository;
use Modules\Pemedic\Repositories\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class VoucherService {
	/**
     * @var VoucherRepository
     */
    private $repository;

    /**
     * @var VoucherPatientRepository
     */
    private $voucherPatientRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

	public function __construct(VoucherRepository $repository, VoucherPatientRepository $voucherPatientRepository, UserRepository $userRepository){
		$this->repository = $repository;
		$this->voucherPatientRepository = $voucherPatientRepository;
		$this->userRepository = $userRepository;
	}

	public function getListVouchers($user, $page = false, $take = false){
		return $this->repository->getList('list', $user, $page, $take);
	} 

	public function getAllVouchers($user, $page = false, $take = false){
		return $this->repository->getAll($user);
	} 

	public function getPaginator($items, $currentPage = false, $perPage = false){
		// $items = $this->repository->getAll($user);
		$total = count($items);
		$paginate = new Paginator($items, $total, $perPage, $currentPage);

		return $paginate;
	}

	public function getToggleNotify($user){
		$dataUser = $this->userRepository->find($user->id);
		$newStatus = $dataUser->profile->is_receive_voucher ? 0 : 1;
		$dataUser->profile->update(['is_receive_voucher' => $newStatus]);

		return $dataUser;
	}

	public function deleteVoucher($id){
		$voucherPatient = $this->voucherPatientRepository->find($id);
		if(count($voucherPatient)){
			$voucherPatient->delete();
		}
	}

	/**
	 * Author: Dung Vo
	 * [findVoucherPatient description]
	 * @param  [type] $id   [description]
	 * @param  [type] $user [description]
	 * @return [type]       [description]
	 */
	public function findVoucherPatient($id, $user){
		return $this->voucherPatientRepository->findByAttributes(['id' => $id, 'patient_id' => $user->id]);
	}
}