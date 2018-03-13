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
     * @param $user
     * @description: create activation user record
     */
    public function activateUser($user,$status) {
        $activationQuery = DB::table("activations")
            ->select('activations.code', 'activations.completed')
            ->where('activations.user_id', $user->id)
            ->first();

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
    
}
