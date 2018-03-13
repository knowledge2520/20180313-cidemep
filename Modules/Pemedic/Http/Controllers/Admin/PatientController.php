<?php

namespace Modules\Pemedic\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Pemedic\Entities\User;
use Modules\Pemedic\Http\Requests\Patients\CreatePatientRequest;
use Modules\Pemedic\Http\Requests\Patients\UpdatePatientRequest;
use Modules\Pemedic\Repositories\UserProfileRepository;
use Modules\Pemedic\Repositories\UserRepository;
use Modules\Pemedic\Services\UserService;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Pemedic\Repositories\ClinicProfileRepository;


class PatientController extends AdminBaseController
{
    /**
     * @var UserProfileRepository
     */
    private $userProfileRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var ClinicProfileRepository
     */
    private $clinicProfileRepository;

    public function __construct(UserProfileRepository $userProfileRepository,UserRepository $userRepository,UserService $userService,ClinicProfileRepository $clinicProfileRepository)
    {
        parent::__construct();

        $this->userProfileRepository    = $userProfileRepository;
        $this->userRepository           = $userRepository;
        $this->userService              = $userService;
        $this->clinicProfileRepository  = $clinicProfileRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $patients   = $this->userProfileRepository->items(config('asgard.userprofile.config.roles.patient'));
        if($request->has('clinic_id') && $request->clinic_id !=0)
        {
            $patients   = $this->userProfileRepository->filterClinic(config('asgard.userprofile.config.roles.patient'),$request->clinic_id);
        }
        $clinics    = $this->clinicProfileRepository->all();
        return view('pemedic::admin.patients.index', compact('patients','clinics','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $clinics    = $this->clinicProfileRepository->all();
        return view('pemedic::admin.patients.create',compact('clinics','request'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePemedicRequest $request
     * @return Response
     */
    public function store(CreatePatientRequest $request)
    {
        $this->userService->create($request->all(),config('asgard.userprofile.config.roles.patient'),$request);

        return redirect()->route('admin.patient.patient.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('pemedic::patients.title.patients')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Pemedic $pemedic
     * @return Response
     */
    public function edit(User $patient)
    {
        $clinics    = $this->clinicProfileRepository->all();
        return view('pemedic::admin.patients.edit', compact('patient','clinics'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Clinic $clinic
     * @param  UpdateClinicRequest $request
     * @return Response
     */
    public function update(User $patient, UpdatePatientRequest $request)
    {
        $this->userService->update($patient,$request->all(),$request);
        return redirect()->route('admin.patient.patient.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('pemedic::patients.title.patients')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $patient
     * @return Response
     */
    public function destroy(User $patient)
    {
        $this->userProfileRepository->destroy($patient->profile);
        $this->userRepository->destroy($patient);
        return redirect()->route('admin.patient.patient.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('pemedic::patients.title.patients')]));
    }

    /**
     *
     * @return Response
     */
    public function exportCsv()
    {
        $this->userService->exportCsv(config('asgard.userprofile.config.roles.patient'));
    }

    /**
     * Remove image when edit patient.
     *
     * @param  Request $request
     * @return Response
     */
    public function deleteImage(Request $request)
    {
        $this->userService->deleteImage($request->patient_id);
    }
    
}
