<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/pemedic'], function (Router $router) {
    $router->bind('pemedic', function ($id) {
        return app('Modules\Pemedic\Repositories\PemedicRepository')->find($id);
    });
    $router->get('pemedics', [
        'as' => 'admin.pemedic.pemedic.index',
        'uses' => 'PemedicController@index',
        'middleware' => 'can:pemedic.pemedics.index'
    ]);
    $router->get('pemedics/create', [
        'as' => 'admin.pemedic.pemedic.create',
        'uses' => 'PemedicController@create',
        'middleware' => 'can:pemedic.pemedics.create'
    ]);
    $router->post('pemedics', [
        'as' => 'admin.pemedic.pemedic.store',
        'uses' => 'PemedicController@store',
        'middleware' => 'can:pemedic.pemedics.create'
    ]);
    $router->get('pemedics/{pemedic}/edit', [
        'as' => 'admin.pemedic.pemedic.edit',
        'uses' => 'PemedicController@edit',
        'middleware' => 'can:pemedic.pemedics.edit'
    ]);
    $router->put('pemedics/{pemedic}', [
        'as' => 'admin.pemedic.pemedic.update',
        'uses' => 'PemedicController@update',
        'middleware' => 'can:pemedic.pemedics.edit'
    ]);
    $router->delete('pemedics/{pemedic}', [
        'as' => 'admin.pemedic.pemedic.destroy',
        'uses' => 'PemedicController@destroy',
        'middleware' => 'can:pemedic.pemedics.destroy'
    ]);
// append

    // router clinic
    $router->bind('clinic', function ($id) {
        return app('Modules\Pemedic\Repositories\ClinicProfileRepository')->find($id);
    });
    $router->get('clinics', [
        'as' => 'admin.clinic.clinic.index',
        'uses' => 'ClinicController@index',
        'middleware' => 'can:clinic.clinics.index'
    ]);
    $router->get('clinics/create', [
        'as' => 'admin.clinic.clinic.create',
        'uses' => 'ClinicController@create',
        'middleware' => 'can:clinic.clinics.create'
    ]);
    $router->post('clinics', [
        'as' => 'admin.clinic.clinic.store',
        'uses' => 'ClinicController@store',
        'middleware' => 'can:clinic.clinics.create'
    ]);
    $router->get('clinics/{clinic}/edit', [
        'as' => 'admin.clinic.clinic.edit',
        'uses' => 'ClinicController@edit',
        'middleware' => 'can:clinic.clinics.edit'
    ]);
    $router->put('clinics/{clinic}', [
        'as' => 'admin.clinic.clinic.update',
        'uses' => 'ClinicController@update',
        'middleware' => 'can:clinic.clinics.edit'
    ]);
    $router->delete('clinics/{clinic}', [
        'as' => 'admin.clinic.clinic.destroy',
        'uses' => 'ClinicController@destroy',
        'middleware' => 'can:clinic.clinics.destroy'
    ]);
    $router->get('clinics/delete-image', [
        'as' => 'admin.clinic.clinic.deleteImage',
        'uses' => 'ClinicController@deleteImage',
        'middleware' => 'can:clinic.clinics.edit'
    ]);


    // router patient
    $router->bind('patient', function ($id) {
        return app('Modules\Pemedic\Repositories\UserRepository')->find($id);
    });

    $router->get('patients', [
        'as' => 'admin.patient.patient.index',
        'uses' => 'PatientController@index',
        'middleware' => 'can:patient.patients.index'
    ]);
    $router->get('patients/create', [
        'as' => 'admin.patient.patient.create',
        'uses' => 'PatientController@create',
        'middleware' => 'can:patient.patients.create'
    ]);
    $router->post('patients', [
        'as' => 'admin.patient.patient.store',
        'uses' => 'PatientController@store',
        'middleware' => 'can:patient.patients.create'
    ]);
    $router->get('patients/{patient}/edit', [
        'as' => 'admin.patient.patient.edit',
        'uses' => 'PatientController@edit',
        'middleware' => 'can:patient.patients.edit'
    ]);
    $router->put('patients/{patient}', [
        'as' => 'admin.patient.patient.update',
        'uses' => 'PatientController@update',
        'middleware' => 'can:patient.patients.edit'
    ]);
    $router->delete('patients/{patient}', [
        'as' => 'admin.patient.patient.destroy',
        'uses' => 'PatientController@destroy',
        'middleware' => 'can:patient.patients.destroy'
    ]);
    $router->get('patients/export', [
        'as' => 'admin.patient.export.index',
        'uses' => 'PatientController@exportCsv',
        'middleware' => 'can:patient.patients.index'
    ]);
    $router->get('patients/delete-image', [
        'as' => 'admin.patient.patient.deleteImage',
        'uses' => 'PatientController@deleteImage',
        'middleware' => 'can:patient.patients.edit'
    ]);
    $router->post('patients/bulk-delete', [
        'as' => 'admin.patient.patient.bulkdelete',
        'uses' => 'PatientController@bulkDelete',
        'middleware' => 'can:patient.patients.destroy'
    ]);

    // router doctor
    $router->bind('doctor', function ($id) {
        return app('Modules\Pemedic\Repositories\UserRepository')->find($id);
    });
    $router->get('doctors', [
        'as' => 'admin.doctor.doctor.index',
        'uses' => 'DoctorController@index',
        'middleware' => 'can:doctor.doctors.index'
    ]);
    $router->get('doctors/create', [
        'as' => 'admin.doctor.doctor.create',
        'uses' => 'DoctorController@create',
        'middleware' => 'can:doctor.doctors.create'
    ]);
    $router->post('doctors', [
        'as' => 'admin.doctor.doctor.store',
        'uses' => 'DoctorController@store',
        'middleware' => 'can:doctor.doctors.create'
    ]);
    $router->get('doctors/{doctor}/edit', [
        'as' => 'admin.doctor.doctor.edit',
        'uses' => 'DoctorController@edit',
        'middleware' => 'can:doctor.doctors.edit'
    ]);
    $router->put('doctors/{doctor}', [
        'as' => 'admin.doctor.doctor.update',
        'uses' => 'DoctorController@update',
        'middleware' => 'can:doctor.doctors.edit'
    ]);
    $router->delete('doctors/{doctor}', [
        'as' => 'admin.doctor.doctor.destroy',
        'uses' => 'DoctorController@destroy',
        'middleware' => 'can:doctor.doctors.destroy'
    ]);
    $router->get('doctors/export', [
        'as' => 'admin.doctor.export.index',
        'uses' => 'DoctorController@exportCsv',
        'middleware' => 'can:doctor.doctors.index'
    ]);
    $router->get('doctors/delete-image', [
        'as' => 'admin.doctor.doctor.deleteImage',
        'uses' => 'DoctorController@deleteImage',
        'middleware' => 'can:doctor.doctors.edit'
    ]);

    $router->post('doctors/bulk-delete', [
        'as' => 'admin.doctor.doctor.bulkdelete',
        'uses' => 'DoctorController@bulkDelete',
        'middleware' => 'can:doctor.doctors.destroy'
    ]);

    // router medical record
    $router->bind('medical', function ($id) {
        return app('Modules\Pemedic\Repositories\MedicalRecordRepository')->find($id);
    });

    $router->get('medicals', [
        'as' => 'admin.medical.medical.index',
        'uses' => 'MedicalController@index',
        'middleware' => 'can:medical.medicals.index'
    ]);
    $router->get('medicals/create', [
        'as' => 'admin.medical.medical.create',
        'uses' => 'MedicalController@create',
        'middleware' => 'can:medical.medicals.create'
    ]);
    $router->post('medicals', [
        'as' => 'admin.medical.medical.store',
        'uses' => 'MedicalController@store',
        'middleware' => 'can:medical.medicals.create'
    ]);
    $router->get('medicals/{medical}/edit', [
        'as' => 'admin.medical.medical.edit',
        'uses' => 'MedicalController@edit',
        'middleware' => 'can:medical.medicals.edit'
    ]);
    $router->put('medicals/{medical}', [
        'as' => 'admin.medical.medical.update',
        'uses' => 'MedicalController@update',
        'middleware' => 'can:medical.medicals.edit'
    ]);
    $router->delete('medicals/{medical}', [
        'as' => 'admin.medical.medical.destroy',
        'uses' => 'MedicalController@destroy',
        'middleware' => 'can:medical.medicals.destroy'
    ]);
    $router->get('medicals/export', [
        'as' => 'admin.medical.export.index',
        'uses' => 'MedicalController@exportCsv',
        'middleware' => 'can:medical.medicals.index'
    ]);
    $router->get('medicals/delete-image', [
        'as' => 'admin.medical.medical.deletefile',
        'uses' => 'MedicalController@deleteFile',
        'middleware' => 'can:medical.medicals.edit'
    ]);
    $router->get('medicals/ajax', [
        'as' => 'admin.medical.ajax.getData',
        'uses' => 'MedicalController@getData',
        'middleware' => 'can:medical.medicals.create'
    ]);
    $router->post('medicals/bulk-delete', [
        'as' => 'admin.medical.medical.bulkdelete',
        'uses' => 'MedicalController@bulkDelete',
        'middleware' => 'can:medical.medicals.destroy'
    ]);


    // router news
    $router->bind('new', function ($id) {
        return app('Modules\Pemedic\Repositories\NewRepository')->find($id);
    });
    $router->get('news', [
        'as' => 'admin.new.new.index',
        'uses' => 'NewsController@index',
        'middleware' => 'can:new.news.index'
    ]);
    $router->get('news/create', [
        'as' => 'admin.new.new.create',
        'uses' => 'NewsController@create',
        'middleware' => 'can:new.news.create'
    ]);
    $router->post('news', [
        'as' => 'admin.new.new.store',
        'uses' => 'NewsController@store',
        'middleware' => 'can:new.news.create'
    ]);
    $router->get('news/{new}/edit', [
        'as' => 'admin.new.new.edit',
        'uses' => 'NewsController@edit',
        'middleware' => 'can:new.news.edit'
    ]);
    $router->put('news/{new}', [
        'as' => 'admin.new.new.update',
        'uses' => 'NewsController@update',
        'middleware' => 'can:new.news.edit'
    ]);
    $router->delete('news/{new}', [
        'as' => 'admin.new.new.destroy',
        'uses' => 'NewsController@destroy',
        'middleware' => 'can:new.news.destroy'
    ]);

    $router->get('news/delete-image', [
        'as' => 'admin.new.new.deleteImage',
        'uses' => 'NewsController@deleteImage',
        'middleware' => 'can:new.news.edit'
    ]);

    // router insurance
    $router->bind('insurance', function ($id) {
        return app('Modules\Pemedic\Repositories\InsuranceRepository')->find($id);
    });
    $router->get('insurances', [
        'as' => 'admin.insurance.insurance.index',
        'uses' => 'InsuranceController@index',
        'middleware' => 'can:insurance.insurances.index'
    ]);
    $router->get('insurances/create', [
        'as' => 'admin.insurance.insurance.create',
        'uses' => 'InsuranceController@create',
        'middleware' => 'can:insurance.insurances.create'
    ]);
    $router->post('news', [
        'as' => 'admin.insurance.insurance.store',
        'uses' => 'InsuranceController@store',
        'middleware' => 'can:insurance.insurances.create'
    ]);
    $router->get('insurances/{insurance}/edit', [
        'as' => 'admin.insurance.insurance.edit',
        'uses' => 'InsuranceController@edit',
        'middleware' => 'can:insurance.insurances.edit'
    ]);
    $router->put('insurances/{insurance}', [
        'as' => 'admin.insurance.insurance.update',
        'uses' => 'InsuranceController@update',
        'middleware' => 'can:insurance.insurances.edit'
    ]);
    $router->delete('insurances/{insurance}', [
        'as' => 'admin.insurance.insurance.destroy',
        'uses' => 'InsuranceController@destroy',
        'middleware' => 'can:insurance.insurances.destroy'
    ]);

    $router->get('insurances/delete-image', [
        'as' => 'admin.insurance.insurance.deleteImage',
        'uses' => 'InsuranceController@deleteImage',
        'middleware' => 'can:insurance.insurances.edit'
    ]);

    // router voucher
    $router->bind('voucher', function ($id) {
        return app('Modules\Pemedic\Repositories\VoucherRepository')->find($id);
    });
    $router->get('vouchers', [
        'as' => 'admin.voucher.voucher.index',
        'uses' => 'VoucherController@index',
        'middleware' => 'can:voucher.vouchers.index'
    ]);
    $router->get('vouchers/create', [
        'as' => 'admin.voucher.voucher.create',
        'uses' => 'VoucherController@create',
        'middleware' => 'can:voucher.vouchers.create'
    ]);
    $router->post('vouchers', [
        'as' => 'admin.voucher.voucher.store',
        'uses' => 'VoucherController@store',
        'middleware' => 'can:voucher.vouchers.create'
    ]);
    $router->get('vouchers/{voucher}/edit', [
        'as' => 'admin.voucher.voucher.edit',
        'uses' => 'VoucherController@edit',
        'middleware' => 'can:voucher.vouchers.edit'
    ]);
    $router->put('vouchers/{voucher}', [
        'as' => 'admin.voucher.voucher.update',
        'uses' => 'VoucherController@update',
        'middleware' => 'can:voucher.vouchers.edit'
    ]);
    $router->delete('vouchers/{voucher}', [
        'as' => 'admin.voucher.voucher.destroy',
        'uses' => 'VoucherController@destroy',
        'middleware' => 'can:voucher.vouchers.destroy'
    ]);
    $router->get('vouchers/delete-image', [
        'as' => 'admin.voucher.voucher.deleteImage',
        'uses' => 'VoucherController@deleteImage',
        'middleware' => 'can:voucher.vouchers.edit'
    ]);
    $router->get('vouchers/{voucher}/view', [
        'as' => 'admin.voucher.voucher.view',
        'uses' => 'VoucherController@view',
        'middleware' => 'can:voucher.vouchers.edit'
    ]);
    $router->get('vouchers/add-patient', [
        'as' => 'admin.voucher.voucher.addPatient',
        'uses' => 'VoucherController@addPatient',
        'middleware' => 'can:voucher.vouchers.edit'
    ]);

});
