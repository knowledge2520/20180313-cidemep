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

    public function pushCriteria(){
		$model = $this->model;

        return $model;
	}

	public function getList($option = "list", $page = false, $limit = false, $messageId = false){

		$offset = ($page - 1) * $limit;
		if($option == "list"){
			$result = $this->pushCriteria()
							->orderBy('id', 'desc')
							->limit($limit)
							->offset($offset)
							->get();

		}else{
			$result = $this->pushCriteria()
							->count();
		}

		return $result;
	}

	public function getAll(){
		return $this->pushCriteria()
					->orderBy('id', 'desc')
					->get();
	}
}