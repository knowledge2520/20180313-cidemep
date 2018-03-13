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
});
