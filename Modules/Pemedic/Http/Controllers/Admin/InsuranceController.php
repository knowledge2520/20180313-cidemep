<?php

namespace Modules\Pemedic\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Pemedic\Repositories\InsuranceRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Pemedic\Http\Requests\Insurance\CreateInsuranceRequest;
use Modules\Pemedic\Http\Requests\Insurance\UpdateInsuranceRequest;
use Modules\Pemedic\Entities\Insurance;

class InsuranceController extends AdminBaseController
{
    /**
     * @var InsuranceRepository
     */
    private $insurance;

    public function __construct(InsuranceRepository $insurance)
    {
        parent::__construct();

        $this->insurance = $insurance;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Insurance index template
     */
    public function index()
    {
        $insurances = $this->insurance->all();
        return view('pemedic::admin.insurances.index', compact('insurances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Insurance create template
     */
    public function create(Request $request)
    {
        return view('pemedic::admin.insurances.create',compact(''));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateInsuranceRequest $request
     * @return Insurance index template
     */
    public function store(CreateInsuranceRequest $request)
    {
    	$insurance = $this->insurance->createInsurance($request,$request->all());
        return redirect()->route('admin.insurance.insurance.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('pemedic::insurances.title.insurances')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Insurance $insurance
     * @return Insurance edit template
     */
    public function edit(Insurance $insurance)
    {
        return view('pemedic::admin.insurances.edit', compact('insurance'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Insurance $insurance
     * @param  UpdateInsuranceRequest $request
     * @return Insurance index template
     */
    public function update(Insurance $insurance, UpdateInsuranceRequest $request)
    {
        $this->insurance->updateInsurance($insurance,$request,$request->all());
        return redirect()->route('admin.insurance.insurance.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('pemedic::insurances.title.insurances')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Insurance $insurance
     * @return Insurance index template
     */
    public function destroy(Insurance $insurance)
    {
        $this->insurance->destroy($insurance);
        return redirect()->route('admin.insurance.insurance.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('pemedic::insurances.title.insurances')]));
    }

    /**
     * Remove image when edit Insurance.
     *
     * @param  Request $request
     */
    public function deleteImage(Request $request)
    {
        $insurance = Insurance::find($request->insurance_id);
        $insurance->image = null;
        $insurance->save();
    }
}
