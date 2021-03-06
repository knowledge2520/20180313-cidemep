<?php

namespace Modules\Pemedic\Repositories\Eloquent;

use Modules\Pemedic\Repositories\UserProfileRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentUserProfileRepository extends EloquentBaseRepository implements UserProfileRepository
{
        /**
         * get user with role_id function
         * @param $role_id
         * @return null / users object
        */
        public function items($role_id)
        {
                return $this->model->select('pemedic__user_profiles.*')
                ->join('users', 'users.id', '=', 'pemedic__user_profiles.user_id', 'right')
                ->join('role_users', 'role_users.user_id', '=', 'users.id', 'inner')
                ->join('roles', 'roles.id', '=', 'role_users.role_id', 'inner')
                ->where('roles.id', $role_id)
                ->groupBy('users.id')
                ->get();
        }

        /**
         * filter users with clinc function
         * @param $role_id
         * @param $clinic_id
         * @return null / users object
        */
        public function filterClinic($role_id,$clinic_id)
        {
                return $this->model->select('pemedic__user_profiles.*','users.email')
                ->join('users', 'users.id', '=', 'pemedic__user_profiles.user_id', 'right')
                ->join('role_users', 'role_users.user_id', '=', 'users.id', 'inner')
                ->join('roles', 'roles.id', '=', 'role_users.role_id', 'inner')
                ->join('pemedic__user_clinic', 'pemedic__user_clinic.user_id', '=', 'users.id', 'inner')
                ->where('roles.id', $role_id)
                ->where('pemedic__user_clinic.clinic_id', $clinic_id)
                ->groupBy('users.id')
                ->get();
        }

        public function destroy($model){
        $model->phone = $model->phone . '_' . \Carbon\carbon::now()->timestamp;
        $model->save();
        $model->delete();

        return true;
    }
}
