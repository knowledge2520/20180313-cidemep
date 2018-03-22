<?php

namespace Modules\Pemedic\Repositories\Eloquent;

use Modules\Pemedic\Repositories\MedicalRecordRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentMedicalRecordRepository extends EloquentBaseRepository implements MedicalRecordRepository
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
		$model = $this->model->with('patient')
							 ->with('doctor')
							 // ->with('clinic')
							 ->whereHas('patient', function($query) use ($user){
								$query->where('patient_id', $user->id);
							 })
							 ->where('is_patient_deleted', 0);
							 /*->whereHas('clinic', function($query){
							 	// $query->where('status', 1);
							 });*/
        return $model;
	}

	/**
	 * Author: Dung Vo
	 * [getList get list medical record]
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
	 * [getAll get all medical record of user]
	 * @param  [type] $user [user]
	 * @return [array]      [list items medical record]
	 */
	public function getAll($user){
		return $this->pushCriteria($user)
					->get();

	}

	public function showListMedicalRecordByPatient($patient)
	{
		$medicalRecords = $this->model->where('patient_id',$patient->id)->groupBy('clinic_id')->get();
		return $medicalRecords;
	}

	public function deleteMedicalRecord($id){
		$medicalRecords = $this->model->where('patient_id',$patient->id)->groupBy('clinic_id')->get();
		return $medicalRecords;
	}
}
