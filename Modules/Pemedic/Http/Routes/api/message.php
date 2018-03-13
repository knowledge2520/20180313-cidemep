<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/message', 'middleware' => ['auth:api','apiLog']], function (Router $router)
{
       $router->get('getListMessages',['uses'=>'MessageController@getListMessages','as'=>'api.message.message.getListMessages', 'before'=>'is_guest']);
});