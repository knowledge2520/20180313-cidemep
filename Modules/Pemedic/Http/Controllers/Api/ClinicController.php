<?php

namespace Modules\Pemedic\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Pemedic\Http\Controllers\Api\ApiBaseController;

class ClinicController extends ApiBaseController{

	public function __construct(){

    }

    /**
     * @SWG\Get(
     *   path="/clinic/getListClinics",
     *   summary="View",
     *   operationId="api.v1.clinic.getListClinics",
     *   produces={"application/json"},
     *   tags={"Clinic"},
     *   @SWG\Response(response=401, description="unauthorized"),
     *   @SWG\Response(response=200, description="Success"),
     *   security={
     *       {"api_key": {}}
     *   }
     * )
     *
     */
    public function getListClinics(Request $request)
    {
        
        return [];

    }

    /**
     * @SWG\Get(
     *   path="/clinic/getListIssurances",
     *   summary="View",
     *   operationId="api.v1.clinic.getListIssurances",
     *   produces={"application/json"},
     *   tags={"Clinic"},
     *   @SWG\Response(response=401, description="unauthorized"),
     *   @SWG\Response(response=200, description="Success"),
     *   security={
     *       {"api_key": {}}
     *   }
     * )
     *
     */
    public function getListIssurances(Request $request)
    {
        return [];
    }
}