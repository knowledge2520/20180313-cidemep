<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/members', 'middleware' => ['apiLog']], function (Router $router) {
       $router->post('postLogin',['uses'=>'AuthenticateController@postLogin','as'=>'api.members.members.postLogin', 'before'=>'is_guest']);
       $router->post('postRegister',['uses'=>'AuthenticateController@postRegister','as'=>'api.members.members.postRegister', 'before'=>'is_guest']);
       $router->post('postForgotPassword',['uses'=>'AuthenticateController@postForgotPassword','as'=>'api.members.members.postForgotPassword', 'before'=>'is_guest']);
});
$router->group(['prefix' =>'/members', 'middleware' => ['auth:api','apiLog']], function (Router $router)
{
       $router->get('getLogout',['uses'=>'AuthenticateController@getLogout','as'=>'api.members.members.getLogout', 'before'=>'is_guest']);
       $router->post('postChangePassword',['uses'=>'AuthenticateController@postChangePassword','as'=>'api.members.members.postChangePassword', 'before'=>'is_guest']);
});

include_once('Routes/api/medicalrecord.php');

include_once('Routes/api/voucher.php');

include_once('Routes/api/message.php');

include_once('Routes/api/news.php');

include_once('Routes/api/clinic.php');

include_once('Routes/api/page.php');

include_once('Routes/api/search.php');