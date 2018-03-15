<?php

namespace Modules\Pemedic\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Pemedic\Repositories\NewRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Pemedic\Http\Requests\News\CreateNewsRequest;
use Modules\Pemedic\Http\Requests\News\UpdateNewsRequest;
use Modules\Pemedic\Entities\News;
use Modules\Pemedic\Entities\NewsTranslation;

class NewsController extends AdminBaseController
{
    /**
     * @var NewRepository
     */
    private $new;

    public function __construct(NewRepository $new)
    {
        parent::__construct();

        $this->new = $new;
    }

    /**
     * Display a listing of the resource.
     *
     * @return news index template
     */
    public function index()
    {
    	$locale = $this->getLocal();
        $news = $this->new->all();
        return view('pemedic::admin.news.index', compact('news','locale'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return news create template
     */
    public function create(Request $request)
    {
        return view('pemedic::admin.news.create',compact(''));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateNewsRequest $request
     * @return news index template
     */
    public function store(CreateNewsRequest $request)
    {
    	$new = $this->new->createNew($request);
        return redirect()->route('admin.new.new.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('pemedic::news.title.news')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  News $new
     * @return news edit template
     */
    public function edit(News $new)
    {
        return view('pemedic::admin.news.edit', compact('new'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  News $new
     * @param  UpdateNewsRequest $request
     * @return news index template
     */
    public function update(News $new, UpdateNewsRequest $request)
    {
        $this->new->updateNew($new,$request);
        return redirect()->route('admin.new.new.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('pemedic::news.title.news')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  News $new
     * @return news index template
     */
    public function destroy(News $new)
    {
        $this->new->destroy($new);
        return redirect()->route('admin.new.new.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('pemedic::news.title.news')]));
    }

    /**
     * Remove image when edit clinic.
     *
     * @param  Request $request
     */
    public function deleteImage(Request $request)
    {
        $translate = NewsTranslation::find($request->translate_id);
        $translate->image = null;
        $translate->image_thumb = null;
        $translate->save();
    }

    /**
     * Get Locale System
     *
     * @return locale system
     */
    protected function getLocal()
    {
    	return app()->make('config')->get('translatable.locale')
            ?: app()->make('translator')->getLocale();
    }
}
