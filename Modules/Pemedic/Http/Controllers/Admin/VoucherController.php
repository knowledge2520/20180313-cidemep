<?php

namespace Modules\Pemedic\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Pemedic\Http\Requests\Vouchers\CreateVoucherRequest;
use Modules\Pemedic\Http\Requests\Vouchers\UpdateVoucherRequest;
use Modules\Pemedic\Repositories\UserProfileRepository;
use Modules\Pemedic\Repositories\UserRepository;
use Modules\Pemedic\Services\VoucherService;
use Modules\Pemedic\Entities\Voucher;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Pemedic\Repositories\ClinicProfileRepository;
use Modules\Pemedic\Repositories\VoucherRepository;

class VoucherController extends AdminBaseController
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
     * @var VoucherService
     */
    private $voucherService;

    /**
     * @var ClinicProfileRepository
     */
    private $clinicProfileRepository;

    /**
     * @var VoucherRepository
     */
    private $voucherRepository;

    public function __construct(UserProfileRepository $userProfileRepository,UserRepository $userRepository,VoucherService $voucherService,ClinicProfileRepository $clinicProfileRepository,VoucherRepository $voucherRepository)
    {
        parent::__construct();

        $this->userProfileRepository    = $userProfileRepository;
        $this->userRepository           = $userRepository;
        $this->voucherService           = $voucherService;
        $this->clinicProfileRepository  = $clinicProfileRepository;
        $this->voucherRepository        = $voucherRepository;
    }

    /**
     * list vouchers function.
     *
     * @return list voucher template
     */
    public function index(Request $request)
    {
        $vouchers = $this->voucherRepository->all();
        if($request->has('clinic_id') && $request->clinic_id !=0)
        {
            $vouchers   = $this->voucherRepository->getByAttributes(['clinic_id'=>$request->clinic_id]);
        }
        $clinics    = $this->clinicProfileRepository->all();
        return view('pemedic::admin.vouchers.index', compact('vouchers','clinics','request'));
    }

    /**
     * show view create template.
     *
     * @return view create template
     */
    public function create(Request $request)
    {
        $clinics    = $this->clinicProfileRepository->all();
        return view('pemedic::admin.vouchers.create',compact('clinics','request'));
    }

    /**
     * create new voucher function.
     *
     * @param  CreateVoucherRequest $request
     * @return list vouchers
     */
    public function store(CreateVoucherRequest $request)
    {
        $this->voucherService->create($request->all(),$request);

        return redirect()->route('admin.voucher.voucher.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('pemedic::vouchers.title.vouchers')]));
    }

    /**
     * Show edit vouchers template.
     *
     * @param  Voucher $voucher
     * @return view edit template
     */
    public function edit(Voucher $voucher)
    {
        $clinics    = $this->clinicProfileRepository->all();
        return view('pemedic::admin.vouchers.edit', compact('voucher','clinics'));
    }

    /**
     * Post update voucher function.
     *
     * @param  Voucher $voucher
     * @param  UpdateVoucherRequest $request
     * @return list voucher template
     */
    public function update(Voucher $voucher, UpdateVoucherRequest $request)
    {
        $this->voucherService->update($voucher,$request->all(),$request);
        return redirect()->route('admin.voucher.voucher.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('pemedic::vouchers.title.vouchers')]));
    }

    /**
     * Show view vouchers template.
     *
     * @param  Voucher $voucher
     * @return view template
     */
    public function view(Voucher $voucher)
    {
        $patients   = $this->userProfileRepository->filterClinic(config('asgard.userprofile.config.roles.patient'),$voucher->clinic_id);
        return view('pemedic::admin.vouchers.view', compact('voucher','patients'));
    }

    /**
     * Remove voucher function.
     *
     * @param  Voucher $voucher
     * @return list voucher
     */
    public function destroy(Voucher $voucher)
    {
        $this->voucherRepository->destroy($voucher);
        return redirect()->route('admin.voucher.voucher.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('pemedic::vouchers.title.vouchers')]));
    }

    /**
     * Remove image when edit voucher.
     *
     * @param  Request $request
     */
    public function deleteImage(Request $request)
    {
        $this->voucherService->deleteImage($request->voucher_id);
    }

    /**
     * add/remove patient.
     *
     * @param  Request $request
     */
    public function addPatient(Request $request)
    {
        $this->voucherService->addPatient($request);
    }
}
