<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/medical', 'middleware' => ['auth:api','apiLog']], function (Router $router)
{
		$router->get('getListMedicalRecord',['uses'=>'MedicalRecordController@getListMedicalRecord','as'=>'api.members.members.getListMedicalRecord', 'before'=>'is_guest']);
    	$router->post('add',['uses'=>'MedicalRecordController@add','as'=>'api.medical.add', 'before'=>'is_guest']);
});