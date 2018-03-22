<?php

namespace Modules\Pemedic\Repositories\Eloquent;

use Modules\Pemedic\Repositories\UserRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Pemedic\Entities\UserProfile;
use Modules\Pemedic\Entities\UserRole;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Hash;
use DB;

class EloquentUserRepository extends EloquentBaseRepository implements UserRepository
{
	public function showListUser($roleId,$users)
	{
		$result = [];
		if(count($users) > 0 ){
			foreach ($users as $key => $user) {
				if($user->hasRoleId($roleId)){
					$result += [$key => $user];
				}
			}
		}
		return $result;
	}
    public function addNewUser($roleId,$allRequest,$status)
    {
    	$user = $this->create($allRequest);
    	$user->roles()->attach($roleId);
    	$allRequest['user_id'] = $user->id;
    	$userProfile = UserProfile::create($allRequest);
    	if($status == 0)
    	{
    		$this->activateUser($user,$status);
    	}
    	else
    	{
    		$this->activateUser($user,$status);
    	}
    	return $user;
    }

    /**
     * active user function
     * @param $user
     * @param $status
    */
    public function activateUser($user,$status) {
        $activationQuery = DB::table("activations")
            ->select('activations.code', 'activations.completed')
            ->where('activations.user_id', $user->id)
            ->first();

        $user->status = 1;
        $user->save();
        
        if(empty($activationQuery)) {
            $activation = Activation::create($user);
        } else {
            $activation = $activationQuery;
        }
        if($status == 1)
        {
        	Activation::complete($user, $activation->code);
        }
    }

    /**
     * check email user with role function
     * @param $role_id
     * @param $email
     * @return true / false
    */
    public function validateEmail($role_id,$email) {
        $user = $this->model->select('users.*')
                ->where('email', $email)
                ->first();
        if(!empty($user))
        {
            $roles = DB::table("role_users")->select('role_users.*')
                ->where('role_users.user_id', $user->id)
                ->where('role_users.role_id', $role_id)
                ->first();
            if(!empty($roles))
            {
                return false;
            }
            return true;
        }
        return true;
    }
    
    /**
     * [pushDoctorCriteria filter repository]
     * @return object [model]
     */
    public function pushDoctorCriteria(){
        $model = $this->model->with('roles')->with('profile')->whereHas('roles',function($query){
            $query->where('roles.id',4);
        });
        
        $model->where('users.status', 1);
        return $model;
    }

    /**
     * [getListDoctor get list items]
     * @param  string  $option  [list: return list items using pagination; count: return number of list items]
     * @param  string  $keyword [keyword]
     * @param  boolean $page    [page]
     * @param  boolean $limit   [items per page]
     * @return [mixed]          [list: array, count: integer]
     */
    public function getListDoctor($option = "list", $keyword = "", $page = false, $limit = false){
        $offset = ($page - 1) * $limit;
        if($option == "list"){
            $result = [];
            $data = false;
            $query = "SELECT u.*
                        FROM users u 
                        JOIN pemedic__user_profiles p ON p.user_id = u.id 
                        JOIN role_users ul ON ul.user_id = u.id AND ul.role_id = 4 ";
            if($keyword){
                $query.= " WHERE p.full_name LIKE '%$keyword%'";
            }

            $query.= "ORDER BY p.full_name ASC 
                        LIMIT $limit
                        OFFSET $offset";

            $data = \DB::select($query);

            if($data){
                foreach ($data as $item) {
                    $result[] = $this->model->find($item->id);
                }
            }

        }else{
            $result = $this->pushDoctorCriteria()
                            ->whereHas('profile', function($query) use ($keyword){
                                $query->where('full_name', 'LIKE', '%'.$keyword.'%');
                            })
                            ->count();
        }
        return $result;
    }
    
    /**
     * Author: Dung Vo
     * [getAll get all items]
     * @param  string $keyword  [keyword]
     * @return [array]          [list items]
     */
    public function getAllDoctor($keyword = ""){
        if($keyword){
            return $this->pushDoctorCriteria()
                        ->whereHas('profile', function($query) use ($keyword){
                            $query->where('full_name', 'LIKE', '%'.$keyword.'%');
                        })
                        ->get();
        }
        return $this->pushDoctorCriteria()->get();
    }

    /**
     * [findDoctor find doctor]
     * @param  number $id [id doctor]
     * @return object     [item doctor]
     */
    public function findDoctor($id){
        return $this->pushDoctorCriteria()->find($id);
    }

    /**
     * [pushClinicCriteria filter repository]
     * @return object [model]
     */
    public function pushClinicCriteria(){
        $model = $this->model->with('roles')->with('profile')->whereHas('roles',function($query){
            $query->where('roles.id',3);
        });
        
        $model->where('users.status', 1);
        return $model;
    }

    /**
     * [getListDoctor get list items]
     * @param  string  $option  [list: return list items using pagination; count: return number of list items]
     * @param  string  $keyword [keyword]
     * @param  boolean $page    [page]
     * @param  boolean $limit   [items per page]
     * @return [mixed]          [list: array, count: integer]
     */
    public function getListClinic($option = "list", $keyword = "", $page = false, $limit = false){
        $offset = ($page - 1) * $limit;
        if($option == "list"){
            $result = [];
            $data = false;
            $query = "SELECT u.*
                        FROM users u 
                        JOIN pemedic__clinic_profiles p ON p.user_id = u.id 
                        JOIN role_users ul ON ul.user_id = u.id AND ul.role_id = 4 ";
            if($keyword){
                $query.= " WHERE p.clinic_namec LIKE '%$keyword%'";
            }

            $query.= "ORDER BY p.clinic_namec ASC 
                        LIMIT $limit
                        OFFSET $offset";

            $data = \DB::select($query);

            if($data){
                foreach ($data as $item) {
                    $result[] = $this->model->find($item->id);
                }
            }

        }else{
            $result = $this->pushClinicCriteria()
                            ->whereHas('clinicProfile', function($query) use ($keyword){
                                $query->where('clinic_namec', 'LIKE', '%'.$keyword.'%');
                            })
                            ->count();
        }
        return $result;
    }
    
    /**
     * Author: Dung Vo
     * [getAll get all items]
     * @param  string $keyword  [keyword]
     * @return [array]          [list items]
     */
    public function getAllClinic($keyword = ""){
        if($keyword){
            return $this->pushClinicCriteria()
                        ->whereHas('clinicProfile', function($query) use ($keyword){
                            $query->where('clinic_namec', 'LIKE', '%'.$keyword.'%');
                        })
                        ->get();
        }
        return $this->pushClinicCriteria()->get();
    }

    /**
     * [findClinic find Clinic]
     * @param  number $id [id Clinic]
     * @return object     [item Clinic]
     */
    public function findClinic($id){
        return $this->pushClinicCriteria()->find($id);
    }

    public function destroy($model){
        $model->email = $model->email . '_' . \Carbon\carbon::now()->timestamp;
        $model->save();
        $model->delete();

        return true;
    }
}
