<?php

namespace Modules\Pemedic\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Pemedic\Repositories\UserProfileRepository;
use Modules\Pemedic\Services\UserService;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Pemedic\Repositories\ClinicProfileRepository;
use Modules\Pemedic\Repositories\MedicalRecordRepository;
use Modules\Pemedic\Http\Requests\Medicals\CreateMedicalRequest;
use Modules\Pemedic\Http\Requests\Medicals\UpdateMedicalRequest;
use Modules\Pemedic\Services\MedicalService;
use Modules\Pemedic\Entities\MedicalRecord;

class MedicalController extends AdminBaseController
{
    /**
     * @var UserProfileRepository
     */
    private $userProfileRepository;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var ClinicProfileRepository
     */
    private $clinicProfileRepository;

    /**
     * @var MedicalRecordRepository
     */
    private $medicalRecordRepository;

    /**
     * @var MedicalService
     */
    private $medicalService;

    public function __construct(UserProfileRepository $userProfileRepository,UserService $userService,ClinicProfileRepository $clinicProfileRepository,MedicalRecordRepository $medicalRecordRepository,MedicalService $medicalService)
    {
        parent::__construct();

        $this->userProfileRepository    = $userProfileRepository;
        $this->userService              = $userService;
        $this->clinicProfileRepository  = $clinicProfileRepository;
        $this->medicalRecordRepository  = $medicalRecordRepository;
        $this->medicalService           = $medicalService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return index medical record template
     */
    public function index(Request $request)
    {
        $medicals    = $this->medicalRecordRepository->all();
        if($request->has('clinic_id') && $request->clinic_id !=0)
        {
            $medicals   = $this->medicalRecordRepository->getByAttributes(['clinic_id'=>$request->clinic_id]);
        }
        $clinics     = $this->clinicProfileRepository->all();
        return view('pemedic::admin.medicals.index', compact('medicals','request','clinics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return create medical record template
     */
    public function create()
    {
        $clinics     =  $this->clinicProfileRepository->all();
        $patients    =  $this->userProfileRepository->items(config('asgard.userprofile.config.roles.patient'));
        $doctors     =  $this->userProfileRepository->items(config('asgard.userprofile.config.roles.doctor'));
        return view('pemedic::admin.medicals.create',compact('clinics','patients','doctors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateMedicalRequest $request
     * @return index medical record template
     */
    public function store(CreateMedicalRequest $request)
    {
        $this->medicalService->create($request->all(),$request);
        return redirect()->route('admin.medical.medical.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('pemedic::medicals.title.medicals')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  MedicalRecord $medical
     * @return edit medical record template
     */
    public function edit(MedicalRecord $medical)
    {
        $clinics     =  $this->clinicProfileRepository->all();
        $patients    =  $this->userProfileRepository->items(config('asgard.userprofile.config.roles.patient'));
        $doctors     =  $this->userProfileRepository->items(config('asgard.userprofile.config.roles.doctor'));
        return view('pemedic::admin.medicals.edit', compact('medical','clinics','patients','doctors'));
    }

    /*
     * Update the specified resource in storage.
     *
     * @param  MedicalRecord $medical
     * @param  UpdateMedicalRequest $request
     * @return index medical record template
     */
    public function update(MedicalRecord $medical, UpdateMedicalRequest $request)
    {
        $this->medicalService->update($medical,$request->all(),$request);
        return redirect()->route('admin.medical.medical.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('pemedic::medicals.title.medicals')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  MedicalRecord $medical
     * @return index medical record template
     */
    public function destroy(MedicalRecord $medical)
    {
        $this->medicalRecordRepository->destroy($medical);
        return redirect()->route('admin.medical.medical.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('pemedic::medicals.title.medicals')]));
    }

    /**
     * Remove file when edit medical.
     *
     * @param  Request $request
     */
    public function deleteFile(Request $request)
    {
        $this->medicalService->deleteFile($request->file_id);
    }

    /**
     * ajax get data doctor and patient.
     *
     * @param Request $request
     * @return Response json list patient and doctor
     */
    public function getData(Request $request)
    {
        $patients   = $this->userProfileRepository->filterClinic(config('asgard.userprofile.config.roles.patient'),$request->clinic_id);
        $doctors    = $this->userProfileRepository->filterClinic(config('asgard.userprofile.config.roles.doctor'),$request->clinic_id);
        return response()->json(['patient' => $patients,'doctor'=>$doctors]);
    }

    /**
     * bulk delete medical.
     *
     * @param  Request $request
     * @return index medical record template
     */
    public function bulkDelete(Request $request)
    {
        $this->medicalService->bulkDelete($request->medicals);

        return redirect()->route('admin.medical.medical.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('pemedic::medicals.title.medicals')]));
    }
    
}
