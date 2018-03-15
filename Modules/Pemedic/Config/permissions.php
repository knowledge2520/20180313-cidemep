<?php

return [
    'pemedic.pemedics' => [
        'index' => 'pemedic::pemedics.list resource',
        'create' => 'pemedic::pemedics.create resource',
        'edit' => 'pemedic::pemedics.edit resource',
        'destroy' => 'pemedic::pemedics.destroy resource',
    ],

    // config clinic permissons
    'clinic.clinics' => [
        'index' => 'pemedic::clinics.list resource',
        'create' => 'pemedic::clinics.create resource',
        'edit' => 'pemedic::clinics.edit resource',
        'destroy' => 'pemedic::clinics.destroy resource',
    ],

    // config patient permissons
    'patient.patients' => [
        'index' => 'pemedic::patients.list resource',
        'create' => 'pemedic::patients.create resource',
        'edit' => 'pemedic::patients.edit resource',
        'destroy' => 'pemedic::patients.destroy resource',
    ],

    // config doctor permissons
    'doctor.doctors' => [
        'index' => 'pemedic::doctors.list resource',
        'create' => 'pemedic::doctors.create resource',
        'edit' => 'pemedic::doctors.edit resource',
        'destroy' => 'pemedic::doctors.destroy resource',
    ],

    // config medical record permissons
    'medical.medicals' => [
        'index' => 'pemedic::medicals.list resource',
        'create' => 'pemedic::medicals.create resource',
        'edit' => 'pemedic::medicals.edit resource',
        'destroy' => 'pemedic::medicals.destroy resource',
    ],

    // config news permissions
    'new.news' => [
        'index' => 'pemedic::news.list resource',
        'create' => 'pemedic::news.create resource',
        'edit' => 'pemedic::news.edit resource',
        'destroy' => 'pemedic::news.destroy resource',
    ],
];
