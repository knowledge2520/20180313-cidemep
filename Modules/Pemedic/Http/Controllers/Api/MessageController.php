<?php

namespace Modules\Pemedic\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Pemedic\Http\Controllers\Api\ApiBaseController;
use Modules\Pemedic\Services\MessageService;
use Modules\Pemedic\Repositories\MessageRepository;
use Modules\Pemedic\Repositories\UserRepository;
use Modules\Pemedic\Http\Transformer\MessageTransformer;
use Modules\Pemedic\Http\Transformer\DoctorTransformer;
use Modules\Pemedic\Http\Requests\Api\Message\CreateMessageRequest;

class MessageController extends ApiBaseController{

    /**
     * @var MessageService
     */
    protected $service;

    /**
     * @var MedicalRecordRepository
     */
    private $repository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(MessageService $service, MessageRepository $repository, UserRepository $userRepository){
        $this->service = $service;
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    /**
     * @SWG\Get(
     *   path="/message/getListMessages?take={take}&page={page}",
     *   summary="View",
     *   operationId="api.v1.customers.getListMessages",
     *   produces={"application/json"},
     *   tags={"Message"},
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
    public function getListMessages(Request $request, MessageTransformer $messageTransformer)
    {
        $user = Auth::guard('api')->user();
        $take = $request->take ? $request->take : config('asgard.pemedic.config.take');
        $page = $request->page ? $request->page : 1;

        if(isset($user) && !empty($user))
        {
            $messages = $this->service->getListMessages($user, $page, $take);
            $items = $this->repository->getAll($user);
            $paginator = $this->service->getPaginator($items, $page, $take);
            return $this->respondWithPagination($paginator, $messageTransformer->transform($messages));
        }

        return $this->respondNotFound('Account does not exist');
    }

    /**
     * @SWG\Get(
     *   path="/message/getDetailMessage?id={id}&take={take}&page={page}",
     *   summary="View",
     *   operationId="api.v1.customers.getDetailMessage",
     *   produces={"application/json"},
     *   tags={"Message"},
     *   @SWG\Parameter(
     *     description="id of message",
     *     in="path",
     *     name="id",
     *     required=true,
     *     type="integer",
     *     default="" 
     *   ),
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
    public function getDetailMessage(Request $request, MessageTransformer $messageTransformer)
    {
        $user = Auth::guard('api')->user();
        $take = $request->take ? $request->take : config('asgard.pemedic.config.take');
        $page = $request->page ? $request->page : 1;
        $id = $request->id ? $request->id : false;

        if(isset($user) && !empty($user))
        {
            $message = $this->repository->find($id);
            if(!count($message)){
                return $this->respondNotFound('Item not found');
            }
            $items = $this->repository->getAll($user, $messageId);
            $messages = $this->service->getDetailMessage($user, $id, $page, $take);
            $paginator = $this->service->getPaginator($items, $page, $take);
            return $this->respondWithPagination($paginator, $messageTransformer->transform($messages));
        }

        return $this->respondNotFound('Account does not exist');
    }

    /**
     * @SWG\Get(
     *   path="/message/getSearchDoctor?keyword={keyword}",
     *   summary="View",
     *   operationId="api.v1.customers.getSearchDoctor",
     *   produces={"application/json"},
     *   tags={"Message"},
     *   @SWG\Parameter(
     *     description="keyword",
     *     in="path",
     *     name="keyword",
     *     required=false,
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
    public function getSearchDoctor(Request $request, DoctorTransformer $doctorTransformer)
    {
        $user = Auth::guard('api')->user();
        $take = $request->take ? $request->take : 5;
        $page = $request->page ? $request->page : 1;
        $keyword = $request->keyword ? $request->keyword : "";

        if(isset($user) && !empty($user))
        {
            $doctors = $this->service->getListDoctor($keyword, $page, $take);
            $items = $this->userRepository->getAllDoctor($keyword);
            $paginator = $this->service->getPaginator($items, $page, $take);
            return $this->respondWithPagination($paginator, $doctorTransformer->transform($doctors));
        }

        return $this->respondNotFound('Account does not exist');
    }

    /**
     * @SWG\Post(
     *   path="/message/postNewMessage",
     *   summary="View",
     *   operationId="api.message.postNewMessage",
     *   produces={"application/json"},
     *   tags={"Message"},
     *   @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Target customer.",
     *     required=true,
     *    @SWG\Schema(ref="#/definitions/NewMessage")
     *   ),
     *   @SWG\Response(response=101, description="Wrong email or password"),
     *   @SWG\Response(response=102, description="You need to confirm your account"),
     *   @SWG\Response(response=500, description="internal server error"),
     *   security={
     *       {"api_key": {}}
     *   }
     * )
     */
    public function postNewMessage(CreateMessageRequest $request, MessageTransformer $messageTransformer)
    {
        $user = Auth::guard('api')->user();
        $doctor_id = $request->doctor_id ? $request->doctor_id : false;
        $message = $request->message ? $request->message : "";

        if(isset($user) && !empty($user))
        {
            // check doctor exist
            $doctor = $this->userRepository->findDoctor($doctor_id);
            if(!count($doctor)){
                return $this->respondNotFound('Doctor does not exist');
            }

            // add new item
            $item = $this->service->newItemMessage($user, $doctor, $message);

            // send push notification to doctor
            
            // get list message
            $items = $this->repository->getAll($user, $item->id);
            $messages = $this->service->getDetailMessage($user, $item->id, 1, config('asgard.pemedic.config.take'));
            $paginator = $this->service->getPaginator($items, 1, config('asgard.pemedic.config.take'));
            return $this->respondWithPagination($paginator, $messageTransformer->transform($messages));
        }

        return $this->respondNotFound('Account does not exist');
    }
}
