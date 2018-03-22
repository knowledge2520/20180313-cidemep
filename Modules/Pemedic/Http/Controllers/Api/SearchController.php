<?php

namespace Modules\Pemedic\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Pemedic\Http\Controllers\Api\ApiBaseController;
use Modules\Pemedic\Http\Transformer\DoctorTransformer;
use Modules\Pemedic\Http\Transformer\ClinicTransformer;
use Modules\Pemedic\Services\SearchService;

class SearchController extends ApiBaseController{

	public function __construct(){

    }

    /**
     * @SWG\Get(
     *   path="/search/getSearchDoctor?keyword={keyword}",
     *   summary="View",
     *   operationId="api.v1.customers.getSearchDoctor",
     *   produces={"application/json"},
     *   tags={"Search"},
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

        $doctors = $this->service->getListDoctors($keyword, $page, $take);
        $items = $this->service->getAllDoctors($keyword);
        $paginator = $this->service->getPaginator($items, $page, $take);
        return $this->respondWithPagination($paginator, $doctorTransformer->transform($doctors));
    }

    /**
     * @SWG\Get(
     *   path="/search/getSearchClinic?keyword={keyword}",
     *   summary="View",
     *   operationId="api.v1.customers.getSearchClinic",
     *   produces={"application/json"},
     *   tags={"Search"},
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
    public function getSearchClinic(Request $request, ClinicTransformer $transformer)
    {
        $user = Auth::guard('api')->user();
        $take = $request->take ? $request->take : 5;
        $page = $request->page ? $request->page : 1;
        $keyword = $request->keyword ? $request->keyword : "";

        $clinics = $this->service->getListClinics($keyword, $page, $take);
        $items = $this->service->getAllClinics($keyword);
        $paginator = $this->service->getPaginator($items, $page, $take);
        return $this->respondWithPagination($paginator, $doctorTransformer->transform($clinics));
    }
}