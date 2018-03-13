<?php

namespace Modules\Pemedic\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\Pemedic\Http\Controllers\Api\PemedicResponse;
/**
 * @SWG\Swagger(
 *   schemes={"http"},
 *   basePath="",
 *   @SWG\Info(
 *     title="Pemedic API",
 *     version="1.0.0"
 *   ),
 *   @SWG\SecurityScheme(
 *   securityDefinition="api_key",
 *   type="apiKey",
 *   in="header",
 *   name="Authorization"
 *  )
 * )
 */ 
class ApiBaseController extends BaseController
{
     use AuthorizesRequests, DispatchesJobs, ValidatesRequests, PemedicResponse;
}
