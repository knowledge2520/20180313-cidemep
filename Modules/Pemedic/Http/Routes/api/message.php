<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/message', 'middleware' => ['auth:api','apiLog']], function (Router $router)
{
   $router->get('getListMessages',['uses'=>'MessageController@getListMessages','as'=>'api.message.message.getListMessages', 'before'=>'is_guest']);
   $router->get('getDetailMessage',['uses'=>'MessageController@getDetailMessage','as'=>'api.message.message.getDetailMessage', 'before'=>'is_guest']);
   $router->get('getSearchDoctor',['uses'=>'MessageController@getSearchDoctor','as'=>'api.message.message.getSearchDoctor', 'before'=>'is_guest']);
   $router->post('postNewMessage',['uses'=>'MessageController@postNewMessage','as'=>'api.message.message.postNewMessage', 'before'=>'is_guest']);
});