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

    /**
     * Author: Dung Vo
     * [pushCriteria filter repository]
     * @param  boolean $user [user]
     * @return [object]      [model]
     */
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

	/**
	 * Author: Dung Vo
	 * [getList get list voucher]
	 * @param  string  $option [list: return list items using pagination; count: return number of list items]
	 * @param  [type]  $user   [object user]
	 * @param  boolean $page   [position page]
	 * @param  boolean $limit  [limit of pagination]
	 * @return [mixed]          [list: array, count: intteger]
	 */
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

	/**
	 * Author: Dung Vo
	 * [getAll get all voucher of user]
	 * @param  [type] $user [user]
	 * @return [array]      [list items voucher]
	 */
	public function getAll($user){
		return $this->pushCriteria($user)
					->get();

	}
}