<?php

namespace Modules\Pemedic\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Pemedic\Entities\Pemedic;
use Modules\Pemedic\Http\Requests\CreatePemedicRequest;
use Modules\Pemedic\Http\Requests\UpdatePemedicRequest;
use Modules\Pemedic\Repositories\PemedicRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class PemedicController extends AdminBaseController
{
    /**
     * @var PemedicRepository
     */
    private $pemedic;

    public function __construct(PemedicRepository $pemedic)
    {
        parent::__construct();

        $this->pemedic = $pemedic;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$pemedics = $this->pemedic->all();

        return view('pemedic::admin.pemedics.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('pemedic::admin.pemedics.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePemedicRequest $request
     * @return Response
     */
    public function store(CreatePemedicRequest $request)
    {
        $this->pemedic->create($request->all());

        return redirect()->route('admin.pemedic.pemedic.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('pemedic::pemedics.title.pemedics')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Pemedic $pemedic
     * @return Response
     */
    public function edit(Pemedic $pemedic)
    {
        return view('pemedic::admin.pemedics.edit', compact('pemedic'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Pemedic $pemedic
     * @param  UpdatePemedicRequest $request
     * @return Response
     */
    public function update(Pemedic $pemedic, UpdatePemedicRequest $request)
    {
        $this->pemedic->update($pemedic, $request->all());

        return redirect()->route('admin.pemedic.pemedic.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('pemedic::pemedics.title.pemedics')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Pemedic $pemedic
     * @return Response
     */
    public function destroy(Pemedic $pemedic)
    {
        $this->pemedic->destroy($pemedic);

        return redirect()->route('admin.pemedic.pemedic.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('pemedic::pemedics.title.pemedics')]));
    }
}
