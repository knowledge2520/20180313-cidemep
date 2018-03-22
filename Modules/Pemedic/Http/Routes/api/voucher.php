<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/voucher', 'middleware' => ['auth:api','apiLog']], function (Router $router)
{
   $router->get('getListVouchers',['uses'=>'VoucherController@getListVouchers','as'=>'api.voucher.voucher.getListVouchers', 'before'=>'is_guest']);
   $router->get('getToggleNofify',['uses'=>'VoucherController@getToggleNofify','as'=>'api.voucher.voucher.getToggleNofify', 'before'=>'is_guest']);
   $router->get('deleteVoucher',['uses'=>'VoucherController@deleteVoucher','as'=>'api.voucher.voucher.deleteVoucher', 'before'=>'is_guest']);
});