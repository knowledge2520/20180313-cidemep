<?php

namespace Modules\Pemedic\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Pemedic\Http\Controllers\Api\ApiBaseController;

class PageController extends ApiBaseController{

	public function __construct(){

    }

    /**
     * @SWG\Get(
     *   path="/page/getTermAndCondition",
     *   summary="View",
     *   operationId="api.v1.page.getTermAndCondition",
     *   produces={"application/json"},
     *   tags={"Page"},
     *   @SWG\Response(response=401, description="unauthorized"),
     *   @SWG\Response(response=200, description="Success"),
     *   security={
     *       {"api_key": {}}
     *   }
     * )
     *
     */
    public function getTermAndCondition(Request $request)
    {

    }
}