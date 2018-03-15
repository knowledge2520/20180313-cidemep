<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/news', 'middleware' => ['auth:api','apiLog']], function (Router $router)
{
   $router->get('getListNews',['uses'=>'NewsController@getListNews','as'=>'api.news.news.getListNews', 'before'=>'is_guest']);
   $router->get('getToggleNofify',['uses'=>'NewsController@getToggleNofify','as'=>'api.news.news.getToggleNofify', 'before'=>'is_guest']);
   $router->get('getDetailNews',['uses'=>'NewsController@getDetailNews','as'=>'api.news.news.getDetailNews', 'before'=>'is_guest']);
});