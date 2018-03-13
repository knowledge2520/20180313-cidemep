<?php 
namespace Modules\Pemedic\Service;

use Modules\Pemedic\Repositories\MessageRepository;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Modules\Pemedic\Criteria\MessageCriteria;

class MessageService {


	/**
     * @var MedicalRecordRepository
     */
    private $repository;

	public function __construct(MessageRepository $repository){
		$this->repository = $repository;
	}

	public function getListMessages($user, $page = false, $take = false){
		$this->repository->pushCriteria(new MessageCriteria());
		return $this->repository->getList('list', $user, $page, $take);
	} 

	public function countMessages($user){
		$this->repository->pushCriteria(new MessageCriteria());
		return $this->repository->getList('count', $user);
	}

	public function getPaginator($user, $currentPage = false, $perPage = false){
		$this->repository->pushCriteria(new MessageCriteria());
		$items = $this->repository->getAll($user);
		$total = count($items);
		$paginate = new Paginator($items, $total, $perPage, $currentPage);

		return $paginate;
	}
}
