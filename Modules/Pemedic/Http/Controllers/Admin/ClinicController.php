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
     * @return Response
     */
    public function index()
    {
        $clinics = $this->clinic->all();
        return view('pemedic::admin.clinics.index', compact('clinics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('pemedic::admin.clinics.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePemedicRequest $request
     * @return Response
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
     * @param  Pemedic $pemedic
     * @return Response
     */
    public function edit(ClinicProfile $clinic)
    {
        return view('pemedic::admin.clinics.edit', compact('clinic'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Clinic $clinic
     * @param  UpdateClinicRequest $request
     * @return Response
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
     * @param  Pemedic $pemedic
     * @return Response
     */
    public function destroy(ClinicProfile $clinic)
    {
        $this->clinic->destroy($clinic);
        $this->userRepository->destroy($clinic->user);
        return redirect()->route('admin.clinic.clinic.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('pemedic::clinics.title.clinics')]));
    }

    /**
     * Remove image when edit clinic.
     *
     * @param  Request $request
     * @return Response
     */
    public function deleteImage(Request $request)
    {
        $this->clinicService->deleteImage($request->clinic_id);
    }
}
