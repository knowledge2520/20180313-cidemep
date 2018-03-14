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

    public function pushCriteria(){
		$model = $this->model->with('doctor')->whereHas('doctor',function($query){
            $query->where('status',1);
            $query->whereNull('deleted_at');
        });
        $model->where('patient_deleted', 0);
        return $model;
	}

	public function getList($option = "list", $user, $page = false, $limit = false, $messageId = false){

		$offset = ($page - 1) * $limit;
		if($option == "list"){
			$result = [];

			if(!$messageId){
				$query = "SELECT m.* 
							FROM (SELECT * FROM pemedic__message ORDER BY id DESC) AS m
							JOIN users AS up ON up.id = m.patient_id AND up.status = 1 AND up.deleted_at IS NULL
							JOIN users AS ud ON ud.id = m.doctor_id AND ud.status = 1 AND ud.deleted_at IS NULL
							JOIN pemedic__user_profiles AS p ON p.user_id = up.id 
							WHERE m.patient_id = $user->id AND m.patient_deleted = 0 AND m.deleted_at IS NULL
							GROUP BY m.doctor_id
							ORDER BY m.id DESC
							LIMIT $limit 
							OFFSET $offset";
			}else{
				$message = $this->model->find($messageId);
				$query = "SELECT m.* 
							FROM (SELECT * FROM pemedic__message ORDER BY id DESC) AS m
							JOIN users AS up ON up.id = m.patient_id AND up.status = 1 AND up.deleted_at IS NULL
							JOIN users AS ud ON ud.id = m.doctor_id AND ud.status = 1 AND ud.deleted_at IS NULL
							JOIN pemedic__user_profiles AS p ON p.user_id = up.id 
							WHERE m.patient_id = $user->id AND m.patient_deleted = 0 AND m.deleted_at IS NULL AND m.doctor_id = $message->doctor_id
							ORDER BY m.id DESC
							LIMIT $limit 
							OFFSET $offset";
			}
			$data = \DB::select($query);
			if($data){
				foreach ($data as $item) {
					$result[] = $this->model->find($item->id);
				}
			}

		}else{
			if(!$messageId){
				$result = $this->pushCriteria()
							->orderBy('id', 'desc')
							->where('patient_id', $user->id)
							->groupBy('doctor_id')
							->count();
			}else{
				$message = $this->model->find($messageId);
				$result = $this->pushCriteria()
							->orderBy('id', 'desc')
							->where('doctor_id', $message->doctor_id)
							->where('patient_id', $user->id)
							->count();
			}
			
		}

		return $result;
	}

	public function getAll($user, $messageId = false){
		if(!$messageId){
			return $this->pushCriteria()
					->where('patient_id', $user->id)
					->groupBy('doctor_id')
					->orderBy('id', 'desc')
					->get();
		}
		
		$message = $this->model->find($messageId);
		if(count($message)){
			return $this->pushCriteria()
					->where('doctor_id', $message->doctor_id)
					->where('patient_id', $user->id)
					->orderBy('id', 'desc')
					->get();
		}

		return [];
	}

}
