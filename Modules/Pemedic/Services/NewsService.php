<?php 
namespace Modules\Pemedic\Services;

use Modules\Pemedic\Repositories\MessageRepository;
use Modules\Pemedic\Repositories\NewsRepository;
use Modules\Pemedic\Repositories\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class NewsService {
	/**
     * @var NewsRepository
     */
    private $repository;

    /**
     * @var UserRepository
     */
    private $userRepository;

	public function __construct(NewsRepository $repository, UserRepository $userRepository){
		$this->repository = $repository;
		$this->userRepository = $userRepository;
	}

	public function getListNews($lang = 'en', $page = false, $take = false){
		return $this->repository->getList('list', $lang, $page, $take);
	} 

	public function getPaginator($items, $currentPage = false, $perPage = false){
		// $items = $this->repository->getAll($user);
		$total = count($items);
		$paginate = new Paginator($items, $total, $perPage, $currentPage);

		return $paginate;
	}

	public function getAllNews(){
		return $this->repository->getAll();
	} 

	public function getToggleNotify($user){
		$dataUser = $this->userRepository->find($user->id);
		$newStatus = $dataUser->profile->is_receive_news ? 0 : 1;
		$dataUser->profile->update(['is_receive_news' => $newStatus]);
		return $dataUser;
	}
}