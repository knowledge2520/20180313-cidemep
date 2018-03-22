<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/clinic', 'middleware' => ['auth:api','apiLog']], function (Router $router)
{
   $router->get('getListClinics',['uses'=>'ClinicController@getListClinics','as'=>'api.clinic.clinic.getListClinics', 'before'=>'is_guest']);
   $router->get('getListIssurances',['uses'=>'ClinicController@getListIssurances','as'=>'api.clinic.clinic.getListIssurances', 'before'=>'is_guest']);
});