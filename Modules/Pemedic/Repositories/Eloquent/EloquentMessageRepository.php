<?php

namespace Modules\Pemedic\Repositories\Eloquent;

use Modules\Pemedic\Repositories\MessageRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentMessageRepository extends EloquentBaseRepository implements MessageRepository
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

	public function getList($option = "list", $user, $page = false, $limit = false){
		$offset = ($page - 1) * $limit;
		if($option == "list"){
			$result = [];
			$data = \DB::select("SELECT m.* 
							FROM (SELECT * FROM pemedic__message ORDER BY id DESC) AS m
							LEFT JOIN users AS u ON u.id = m.patient_id 
							LEFT JOIN pemedic__user_profiles AS p ON p.user_id = u.id 
							WHERE m.patient_id = $user->id AND m.patient_deleted = 0 
							GROUP BY m.doctor_id
							ORDER BY m.id DESC
							LIMIT $limit 
							OFFSET $offset");

			if($data){
				foreach ($data as $item) {
					$result[] = $this->model->find($item->id);
				}
			}

		}else{
			$result = $this->model->orderBy('id', 'desc')
							->where('patient_id', $user->id)
							->where('patient_deleted', 0)
							->groupBy('doctor_id')
							->count();
		}

		return $result;
	}

	public function getAll($user){
		return $this->model->orderBy('id', 'desc')
							->where('patient_id', $user->id)
							->where('patient_deleted', 0)
							->groupBy('doctor_id')
							->get();
	}
}
