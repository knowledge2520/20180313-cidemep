<?php 
namespace Modules\Pemedic\Services;

use Modules\Pemedic\Repositories\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class SearchService {


	/**
     * @var MessageRepository
     */
    private $repository;

    /**
     * @var UserRepository
     */
    private $userRepository;

	public function __construct(UserRepository $userRepository){
		$this->userRepository = $userRepository;
	}

	public function getListDoctors($keyword, $page = false, $take = false){
		return $this->userRepository->getListDoctors('list', $keyword, $page, $take);
	}

	public function getAllDoctors($keyword){
		return $this->userRepository->getAllDoctors($keyword);
	}

	public function getListClinics($keyword, $page = false, $take = false){
		return $this->userRepository->getListClinics('list', $keyword, $page, $take);
	}

	public function getAllClinics($keyword){
		return $this->userRepository->getAllClinics($keyword);
	}
}
