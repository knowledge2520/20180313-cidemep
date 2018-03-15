<?php

namespace Modules\Pemedic\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Pemedic\Http\Controllers\Api\ApiBaseController;
use Modules\Pemedic\Services\VoucherService;
use Modules\Pemedic\Http\Transformer\VoucherTransformer;
use Modules\Pemedic\Http\Transformer\ToggleNotifyTransformer;
use Modules\Pemedic\Repositories\VoucherRepository;
use Modules\Pemedic\Http\Requests\Api\Voucher\DeleteVoucherRequest;

class VoucherController extends ApiBaseController{
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
    
    public function __construct(VoucherService $service, VoucherRepository $repository){
        $this->service = $service;
        $this->repository = $repository;
    }

    /**
     * @SWG\Get(
     *   path="/voucher/getListVouchers?take={take}&page={page}",
     *   summary="View",
     *   operationId="api.v1.voucher.getListVouchers",
     *   produces={"application/json"},
     *   tags={"Voucher"},
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
    public function getListVouchers(Request $request, VoucherTransformer $voucherTransformer)
    {
        $user = Auth::guard('api')->user();
        $take = $request->take ? $request->take : config('asgard.pemedic.config.take');
        $page = $request->page ? $request->page : 1;

        if(isset($user) && !empty($user))
        {
            $vouchers = $this->service->getListVouchers($user, $page, $take);
            $items = $this->service->getAllVouchers($user);
            $paginator = $this->service->getPaginator($items, $page, $take);
            return $this->respondWithPagination($paginator, $voucherTransformer->transform($vouchers));
        }

        return $this->respondNotFound('Account does not exist');
    }

    /**
     * @SWG\Get(
     *   path="/voucher/getToggleNofify",
     *   summary="View",
     *   operationId="api.v1.voucher.getToggleNofify",
     *   produces={"application/json"},
     *   tags={"Voucher"},
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
     *   path="/voucher/getDeleteVoucher?id={id}",
     *   summary="View",
     *   operationId="api.v1.voucher.getDeleteVoucher",
     *   produces={"application/json"},
     *   tags={"Voucher"},
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
    public function getDeleteVoucher(DeleteVoucherRequest $request, ToggleNotifyTransformer $toggleNotifyTransformer)
    {
        $user = Auth::guard('api')->user();
        $id = $request->id ? $request->id : false;

        if(isset($user) && !empty($user))
        {   
            $voucherPatient = $this->service->findVoucherPatient($id, $user);

            if(!count($voucherPatient)){
                return $this->respondNotFound('Item not found');
            }

            // delete item
            $this->service->deleteVoucher($id);

            return $this->respondWithSuccess('Deleted successfully');
        }

        return $this->respondNotFound('Account does not exist');
    }
}
