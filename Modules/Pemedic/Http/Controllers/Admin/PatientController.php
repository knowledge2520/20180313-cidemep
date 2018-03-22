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
     * @return create patient template
     */
    public function create(Request $request)
    {
        $clinics    = $this->clinicProfileRepository->all();
        return view('pemedic::admin.patients.create',compact('clinics','request'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePatientRequest $request
     * @return index patient template
     */
    public function store(CreatePatientRequest $request)
    {
        $validate_email = $this->userRepository->validateEmail(config('asgard.userprofile.config.roles.patient'),$request->email);
        if($validate_email)
        {
            $patient = $this->userService->create($request->all(),config('asgard.userprofile.config.roles.patient'),$request);
            if(!empty($patient))
            {
                return redirect()->route('admin.patient.patient.index')
                    ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('pemedic::patients.title.patients')]));
            }
            else
            {
                return redirect()->route('admin.patient.patient.create')
                    ->with(['email_error'=>"The email has already been taken."]);
            }
        }
        else
        {
            return redirect()->route('admin.patient.patient.create')
                ->with(['email_error'=>"The email has already been taken."]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $patient
     * @return edit patient template
     */
    public function edit(User $patient)
    {
        $clinics    = $this->clinicProfileRepository->all();
        return view('pemedic::admin.patients.edit', compact('patient','clinics'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  User $patient
     * @param  UpdatePatientRequest $request
     * @return index patient template
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
     * @return index patient template
     */
    public function destroy(User $patient)
    {
        $patient->email = $patient->email . time();
        $patient->save();

        $user = $patient->profile;
        $user->phone = $user->phone . time();
        $user->save();
        
        $this->userProfileRepository->destroy($patient->profile);
        $this->userRepository->destroy($patient);
        return redirect()->route('admin.patient.patient.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('pemedic::patients.title.patients')]));
    }

    /**
     *
     *  export patient to csv
     */
    public function exportCsv()
    {
        $this->userService->exportCsv(config('asgard.userprofile.config.roles.patient'));
    }

    /**
     * import patient.
     *
     * @param  Request $request
     * @return index patient template
     */
    public function import(Request $request)
    {
        $patient = $this->userService->import($request);
        return redirect()->route('admin.patient.patient.index')
                ->with(['totalSuccess'=> $patient['totalSuccess'] ,'dataErrors' => $patient['dataErrors'],'formatErrors' => $patient['formatErrors']]);
    }

    /**
     * Remove image when edit patient.
     *
     * @param  Request $request
     */
    public function deleteImage(Request $request)
    {
        $this->userService->deleteImage($request->patient_id);
    }

    /**
     * bulk delete patient.
     *
     * @param  Request $request
     * @return index patient index
     */
    public function bulkDelete(Request $request)
    {
        $this->userService->bulkDelete($request->users);

        return redirect()->route('admin.patient.patient.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('pemedic::patients.title.patients')]));
    }
    
}
