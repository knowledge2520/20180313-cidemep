<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/page', 'middleware' => ['auth:api','apiLog']], function (Router $router)
{
   $router->get('getTermAndCondition',['uses'=>'PageController@getTermAndCondition','as'=>'api.page.page.getTermAndCondition', 'before'=>'is_guest']);
});