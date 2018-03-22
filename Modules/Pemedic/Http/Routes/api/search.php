<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/search', 'middleware' => ['auth:api','apiLog']], function (Router $router)
{
   $router->get('getSearchDoctor',['uses'=>'SearchController@getSearchDoctor','as'=>'api.search.search.getSearchDoctor', 'before'=>'is_guest']);
   $router->get('getSearchClinic',['uses'=>'SearchController@getSearchClinic','as'=>'api.search.search.getSearchClinic', 'before'=>'is_guest']);
});