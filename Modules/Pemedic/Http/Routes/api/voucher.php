<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/voucher', 'middleware' => ['auth:api','apiLog']], function (Router $router)
{
   $router->get('getListVouchers',['uses'=>'VoucherController@getListVouchers','as'=>'api.voucher.voucher.getListVouchers', 'before'=>'is_guest']);
   $router->get('getToggleNofify',['uses'=>'VoucherController@getToggleNofify','as'=>'api.voucher.voucher.getToggleNofify', 'before'=>'is_guest']);
   $router->get('getDeleteVoucher',['uses'=>'VoucherController@getDeleteVoucher','as'=>'api.voucher.voucher.getDeleteVoucher', 'before'=>'is_guest']);
});