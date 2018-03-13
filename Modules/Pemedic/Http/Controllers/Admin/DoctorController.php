<?php

namespace Modules\Pemedic\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Pemedic\Entities\User;
use Modules\Pemedic\Http\Requests\Doctors\CreateDoctorRequest;
use Modules\Pemedic\Http\Requests\Doctors\UpdateDoctorRequest;
use Modules\Pemedic\Repositories\UserProfileRepository;
use Modules\Pemedic\Repositories\UserRepository;
use Modules\Pemedic\Services\UserService;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Pemedic\Repositories\ClinicProfileRepository;

class DoctorController extends AdminBaseController
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
        $doctors = $this->userProfileRepository->items(config('asgard.userprofile.config.roles.doctor'));
        if($request->has('clinic_id') && $request->clinic_id !=0)
        {
            $doctors   = $this->userProfileRepository->filterClinic(config('asgard.userprofile.config.roles.doctor'),$request->clinic_id);
        }
        $clinics    = $this->clinicProfileRepository->all();
        return view('pemedic::admin.doctors.index', compact('doctors','clinics','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $clinics    = $this->clinicProfileRepository->all();
        return view('pemedic::admin.doctors.create',compact('clinics','request'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePemedicRequest $request
     * @return Response
     */
    public function store(CreateDoctorRequest $request)
    {
        $this->userService->create($request->all(),config('asgard.userprofile.config.roles.doctor'),$request);

        return redirect()->route('admin.doctor.doctor.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('pemedic::doctors.title.doctors')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Pemedic $pemedic
     * @return Response
     */
    public function edit(User $doctor)
    {
        $clinics    = $this->clinicProfileRepository->all();
        return view('pemedic::admin.doctors.edit', compact('doctor','clinics'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Clinic $clinic
     * @param  UpdateClinicRequest $request
     * @return Response
     */
    public function update(User $doctor, UpdateDoctorRequest $request)
    {
        $this->userService->update($doctor,$request->all(),$request);
        return redirect()->route('admin.doctor.doctor.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('pemedic::doctors.title.doctors')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Pemedic $pemedic
     * @return Response
     */
    public function destroy(User $doctor)
    {
        $this->userProfileRepository->destroy($doctor->profile);
        $this->userRepository->destroy($doctor);
        return redirect()->route('admin.doctor.doctor.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('pemedic::doctors.title.doctors')]));
    }

    /**
     *
     * @return Response
     */
    public function exportCsv()
    {
        $this->userService->exportCsv(config('asgard.userprofile.config.roles.doctor'));
    }

    /**
     * Remove image when edit doctor.
     *
     * @param  Request $request
     * @return Response
     */
    public function deleteImage(Request $request)
    {
        $this->userService->deleteImage($request->doctor_id);
    }
    
}
