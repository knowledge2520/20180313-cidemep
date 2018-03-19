<?php

namespace Modules\Pemedic\Repositories\Eloquent;

use Modules\Pemedic\Repositories\NewsRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Hash;
use DB;

class EloquentNewsRepository extends EloquentBaseRepository implements NewsRepository
{
	/**
     * @var \Illuminate\Database\Eloquent\Model An instance of the Eloquent Model
     */
    protected $model;

    /**
     * @param Model $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Author: Dung Vo
     * [pushCriteria get model of repository, filter condition]
     * @return [object] [model]
     */
    public function pushCriteria(){
		$model = $this->model;

        return $model;
	}

	/**
	 * Author: Dung Vo
	 * [getList get list items news with pagination or count number items news]
	 * @param  string  $option [list: return list items using pagination; count: return number of list items]
	 * @param  string  $lang   [en, vi]
	 * @param  boolean $page   [position page]
	 * @param  boolean $limit  [limit of pagination]
	 * @return [mixed]         [list: array, count: intteger]
	 */
	public function getList($option = "list", $lang = 'en', $page = false, $limit = false){

		$offset = ($page - 1) * $limit;
		if($option == "list"){
			$result = [];
			$data = $this->pushCriteria()
							->orderBy('id', 'desc')
							->limit($limit)
							->offset($offset)
							->get();

			if(count($data)){
				foreach ($data as $item) {
					$itemTranslate = $item->translate->where('locale', $lang)->first();
					if(count($itemTranslate)){
						$item->title = $itemTranslate->title;
						$item->content = $itemTranslate->content;
					}
					$result[] = $item;
				}
			}
		}else{
			$result = $this->pushCriteria()
							->count();
		}

		return $result;
	}

	/**
	 * Author: Dung Vo
	 * [getAll get all news]
	 * @return [array]      [list items news]
	 */
	public function getAll(){
		return $this->pushCriteria()
					->orderBy('id', 'desc')
					->get();
	}
}