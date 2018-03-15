<?php

namespace Modules\Pemedic\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Pemedic\Http\Controllers\Api\ApiBaseController;
use Modules\Pemedic\Services\NewsService;
use Modules\Pemedic\Http\Transformer\NewsTransformer;
use Modules\Pemedic\Http\Transformer\ToggleNotifyTransformer;
use Modules\Pemedic\Repositories\NewsRepository;
use Modules\Pemedic\Repositories\UserRepository;
use Modules\Pemedic\Http\Requests\Api\News\GetDetailNewsRequest;

class NewsController extends ApiBaseController{

    /**
     * @var VoucherService
     */
    protected $service;

    /**
     * @var VoucherRepository
     */
    private $repository;

    /**
     * @var UserRepository
     */
    private $userRepository;

	public function __construct(NewsService $service, NewsRepository $repository, UserRepository $userRepository){
        $this->service = $service;
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    /**
     * @SWG\Get(
     *   path="/news/getListNews?take={take}&page={page}",
     *   summary="View",
     *   operationId="api.v1.news.getListNews",
     *   produces={"application/json"},
     *   tags={"News"},
     *   @SWG\Parameter(
     *     description="",
     *     in="path",
     *     name="take",
     *     required=false,
     *     type="integer",
     *     default="10" 
     *   ),
     *   @SWG\Parameter(
     *     description="",
     *     in="path",
     *     name="page",
     *     required=false,
     *     type="integer",
     *     default="1" 
     *   ),
     *   @SWG\Response(response=401, description="unauthorized"),
     *   @SWG\Response(response=200, description="Success"),
     *   security={
     *       {"api_key": {}}
     *   }
     * )
     *
     */
    public function getListNews(Request $request, NewsTransformer $newsTransformer)
    {
        $user = Auth::guard('api')->user();
        $take = $request->take ? $request->take : config('asgard.pemedic.config.take');
        $page = $request->page ? $request->page : 1;

        if(isset($user) && !empty($user))
        {
            $dataUser = $this->userRepository->find($user->id);
            
            $news = $items = [];
            if($dataUser->profile && $dataUser->profile->is_receive_news){
                $news = $this->service->getListNews($page, $take);
                $items = $this->service->getAllNews();
            }

            $paginator = $this->service->getPaginator($items, $page, $take);
            return $this->respondWithPagination($paginator, $newsTransformer->transform($news));
        }

        return $this->respondNotFound('Account does not exist');
    }

    /**
     * @SWG\Get(
     *   path="/news/getToggleNofify",
     *   summary="View",
     *   operationId="api.v1.voucher.getToggleNofify",
     *   produces={"application/json"},
     *   tags={"News"},
     *   @SWG\Response(response=401, description="unauthorized"),
     *   @SWG\Response(response=200, description="Success"),
     *   security={
     *       {"api_key": {}}
     *   }
     * )
     *
     */
    public function getToggleNofify(Request $request, ToggleNotifyTransformer $toggleNotifyTransformer)
    {
        $user = Auth::guard('api')->user();

        if(isset($user) && !empty($user))
        {
            $item = $this->service->getToggleNotify($user);

            return $this->respondWithSuccess($toggleNotifyTransformer->transform($item), 'Switch successfully');
        }

        return $this->respondNotFound('Account does not exist');
    }

    /**
     * @SWG\Get(
     *   path="/news/getDetailNews?id={id}",
     *   summary="View",
     *   operationId="api.v1.news.getDetailNews",
     *   produces={"application/json"},
     *   tags={"News"},
     *   @SWG\Parameter(
     *     description="id of message",
     *     in="path",
     *     name="id",
     *     required=true,
     *     type="integer",
     *     default="" 
     *   ),
     *   @SWG\Response(response=401, description="unauthorized"),
     *   @SWG\Response(response=200, description="Success"),
     *   security={
     *       {"api_key": {}}
     *   }
     * )
     *
     */
    public function getDetailNews(GetDetailNewsRequest $request, NewsTransformer $newsTransformer)
    {
        $user = Auth::guard('api')->user();
        $id = $request->id ? $request->id : false;

        if(isset($user) && !empty($user))
        {
            $news = $this->repository->find($id);
            if(!count($news)){
                return $this->respondNotFound('Item not found');
            }

            return $this->respondWithSuccess($newsTransformer->transform($news));
        }

        return $this->respondNotFound('Account does not exist');
    }
}
