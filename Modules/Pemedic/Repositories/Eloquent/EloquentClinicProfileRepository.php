<?php

namespace Modules\Pemedic\Repositories\Eloquent;

use Modules\Pemedic\Repositories\ClinicProfileRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Support\Facades\Hash;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use DB;

class EloquentClinicProfileRepository extends EloquentBaseRepository implements ClinicProfileRepository
{
	public function createUser($data) {

        $driver = config('asgard.user.config.driver', 'Sentinel');
        $userData = [
            'email'     => isset($data['email']) ? $data['email'] : null,
            'password'  => isset($data['password']) ? Hash::make($data['password']) : null,
            'last_name' => isset($data['clinic_name']) ? $data['clinic_name']: null,

        ];
        $user = app("\\Modules\\User\\Entities\\{$driver}\\User")->create($userData);

        return $user;
    }

    /**
     * @param $user
     * @description: create activation user record
     */
    public function activateUser($user) {
        $activationQuery = DB::table("activations")
            ->select('activations.code', 'activations.completed')
            ->where('activations.user_id', $user->id)
            ->first();

        if(empty($activationQuery)) {
            $activation = Activation::create($user);
        } else {
            $activation = $activationQuery;
        }
        // Activation::complete($user, $activation->code);
    }
}
