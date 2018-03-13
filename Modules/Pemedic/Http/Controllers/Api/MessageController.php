<?php

namespace Modules\Pemedic\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Pemedic\Http\Controllers\Api\ApiBaseController;
use Modules\Pemedic\Service\MessageService;
use Modules\Pemedic\Repositories\MessageRepository;
use Modules\Pemedic\Http\Transformer\MessageTransformer;

class MessageController extends ApiBaseController{

    /**
     * @var MessageService
     */
    protected $service;

    /**
     * @var MedicalRecordRepository
     */
    private $repository;

    public function __construct(MessageService $service, MessageRepository $repository){
        $this->service = $service;
        $this->repository = $repository;
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
            $paginator = $this->service->getPaginator($user, $page, $take);

            return $this->respondWithPagination($paginator, $messageTransformer->transform($messages));
        }

        return $this->respondNotFound('Account does not exist');
    }

}
