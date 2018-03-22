<?php

namespace Modules\Pemedic\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Pemedic\Entities\ClinicProfile;
use Modules\Pemedic\Http\Requests\Clinics\CreateClinicRequest;
use Modules\Pemedic\Http\Requests\Clinics\UpdateClinicRequest;
use Modules\Pemedic\Repositories\ClinicProfileRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Pemedic\Services\ClinicService;
use Modules\Pemedic\Repositories\UserRepository;

class ClinicController extends AdminBaseController
{
    /**
     * @var ClinicProfileRepository
     */
    private $clinic;

     /**
     * @var ClinicService
     */
    private $clinicService;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(ClinicProfileRepository $clinic,ClinicService $clinicService,UserRepository $userRepository)
    {
        parent::__construct();

        $this->clinic = $clinic;
        $this->clinicService = $clinicService;
        $this->userRepository           = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return clinic index template
     */
    public function index()
    {
        $clinics = $this->clinic->all();
        return view('pemedic::admin.clinics.index', compact('clinics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return create clinic template
     */
    public function create()
    {
        return view('pemedic::admin.clinics.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateClinicRequest $request
     * @return clinic index template
     */
    public function store(CreateClinicRequest $request)
    {
        $this->clinicService->create($request->all(),$request);

        return redirect()->route('admin.clinic.clinic.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('pemedic::clinics.title.clinics')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ClinicProfile $clinic
     * @return edit clinic template
     */
    public function edit(ClinicProfile $clinic)
    {
        return view('pemedic::admin.clinics.edit', compact('clinic'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ClinicProfile $clinic
     * @param  UpdateClinicRequest $request
     * @return clinic index template
     */
    public function update(ClinicProfile $clinic, UpdateClinicRequest $request)
    {
        $this->clinicService->update($clinic,$request->all(),$request);
        return redirect()->route('admin.clinic.clinic.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('pemedic::clinics.title.clinics')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ClinicProfile $clinic
     * @return clinic index template
     */
    public function destroy(ClinicProfile $clinic)
    {
        $user = $clinic->user;
        $user->email = $user->email . time();
        $user->save();
        $this->clinic->destroy($clinic);
        $this->userRepository->destroy($clinic->user);
        return redirect()->route('admin.clinic.clinic.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('pemedic::clinics.title.clinics')]));
    }

    /**
     * Remove image when edit clinic.
     *
     * @param  Request $request
     */
    public function deleteImage(Request $request)
    {
        $this->clinicService->deleteImage($request->clinic_id);
    }
}
