<?php 
namespace Modules\Pemedic\Services;

use Modules\Pemedic\Repositories\MessageRepository;
use Modules\Pemedic\Repositories\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class MessageService {


	/**
     * @var MessageRepository
     */
    private $repository;

    /**
     * @var UserRepository
     */
    private $userRepository;

	public function __construct(MessageRepository $repository, UserRepository $userRepository){
		$this->repository = $repository;
		$this->userRepository = $userRepository;
	}

	public function getListMessages($user, $page = false, $take = false){
		return $this->repository->getList('list', $user, $page, $take);
	} 

	public function getPaginator($items, $currentPage = false, $perPage = false){
		// $items = $this->repository->getAll($user);
		$total = count($items);
		$paginate = new Paginator($items, $total, $perPage, $currentPage);

		return $paginate;
	}

	public function getDetailMessage($user, $messageId, $page = false, $take = false){
		return $this->repository->getList('list', $user, $page, $take, $messageId);
	} 

	public function getListDoctor($keyword, $page = false, $take = false){
		return $this->userRepository->getListDoctor('list', $keyword, $page, $take);
	}

	public function newItemMessage($user, $doctor, $message){
		$data = [
			'patient_id' => $user->id,
			'doctor_id' => $doctor->id,
			'message' => $message,
			'is_read_patient' => 1
		];
		return $this->repository->create($data);
	}
}
