<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/medical', 'middleware' => ['auth:api','apiLog']], function (Router $router)
{
		$router->get('getListMedicalRecord',['uses'=>'MedicalRecordController@getListMedicalRecord','as'=>'api.members.members.getListMedicalRecord', 'before'=>'is_guest']);
    	$router->post('add',['uses'=>'MedicalRecordController@add','as'=>'api.medical.add', 'before'=>'is_guest']);
    	$router->get('getDetailMedicalRecord',['uses'=>'MedicalRecordController@getDetailMedicalRecord','as'=>'api.medical.getDetailMedicalRecord', 'before'=>'is_guest']);
    	$router->post('updateMedicalRecord',['uses'=>'MedicalRecordController@updateMedicalRecord','as'=>'api.medical.updateMedicalRecord', 'before'=>'is_guest']);
    	$router->post('deleteMedicalRecord',['uses'=>'MedicalRecordController@deleteMedicalRecord','as'=>'api.medical.deleteMedicalRecord', 'before'=>'is_guest']);
    	$router->post('deleteMedicalRecordFile',['uses'=>'MedicalRecordController@deleteMedicalRecordFile','as'=>'api.medical.deleteMedicalRecordFile', 'before'=>'is_guest']);
});