<?php

namespace Modules\Pemedic\Repositories\Eloquent;

use Modules\Pemedic\Repositories\VoucherRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Hash;
use DB;

class EloquentVoucherRepository extends EloquentBaseRepository implements VoucherRepository
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

    public function pushCriteria($user = false){
		$model = $this->model->with('voucherPatient')
							 ->with('clinic')
							 ->whereHas('voucherPatient', function($query) use ($user){
								$query->where('patient_id', $user->id);
							 })
							 ->whereHas('clinic', function($query){
							 	$query->where('status', 1);
							 });
        return $model;
	}

	public function getList($option = "list", $user, $page = false, $limit = false){

		$offset = ($page - 1) * $limit;
		if($option == "list"){
			$result = $this->pushCriteria($user)
							->orderBy('id', 'desc')
							->limit($limit)
							->offset($offset)
							->get();

		}else{
			$result = $this->pushCriteria($user)
							->count();
			
		}

		return $result;
	}

	public function getAll($user){
		return $this->pushCriteria($user)
					->get();

	}
}