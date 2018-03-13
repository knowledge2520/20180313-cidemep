<?php
/**
 * @description: Deal Service class execute the service logic CMS
 */
namespace Modules\Pemedic\Services;

use Modules\Pemedic\Repositories\UserRepository;
use Modules\Pemedic\Repositories\ActivationRepository;
use Modules\Pemedic\Repositories\UserProfileRepository;
use Illuminate\Support\Facades\Hash;
use Modules\Pemedic\Repositories\ClinicProfileRepository;
use Modules\Pemedic\Entities\User;


class UserService {

    /**
     * @var UserProfileRepository
     */
    private $userProfileRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var ClinicProfileRepository
     */
    private $clinicRepository;

    public function __construct(UserProfileRepository $userProfileRepository,UserRepository $userRepository,ClinicProfileRepository $clinicRepository)
    {

        $this->userProfileRepository    = $userProfileRepository;
        $this->userRepository           = $userRepository;
        $this->clinicRepository         = $clinicRepository;
    }

    /**
     * @param array $data
     * @return null / patient object
     */
    public function create($data = array(),$role,$request)
    {
        $password = $this->generatePassword();
        $data['password'] = Hash::make($password);
        $data['dob'] = !empty($data['dob'])?date('Y-m-d', strtotime($data['dob'])):null;

        $data['image'] = null;
        if(!empty($request->file('image')))
        {
            $file = $request->file('image');
            $data['image'] = $this->uploadFile($request->file('image'));
        }

        $user = $this->userRepository->addNewUser($role,$data,0);
        if(!empty($data['clinic_id']))
        {
             // assign role
            $user->clinic()->attach($data['clinic_id']);
        }
        return $user;
        // return $this->userRepository->addNewUser(config('asgard.userprofile.config.roles.patient'),$data,0);
    }

    /**
     * @param userProfile
     * @param array $data
     * @return null / user object
     */
    public function update(User $user,$data = array(),$request)
    {
        $data['dob'] = !empty($data['dob'])?date('Y-m-d', strtotime($data['dob'])):null;
        $this->userRepository->update($user,$data);
        if(!empty($data['clinic_id']))
        {
            $user->clinic()->detach();
            $user->clinic()->attach($data['clinic_id']);
        }
        if(!empty($request->file('image')))
        {
            $file = $request->file('image');
            $data['image'] = $this->uploadFile($request->file('image'));
        }
        return $this->userProfileRepository->update($user->profile,$data);
    }

    /**
     * @param role_id
     * @return null / user object
     */
    public function exportCsv($role_id)
    {   
        $users = $this->userProfileRepository->items($role_id);
        \Excel::create('users', function($excel) use($users) {
            $excel->sheet('ExportFile', function($sheet) use($users) {
              $sheet->loadView('pemedic::admin.csvs.export-csv',['users' => $users]);
            });
        })->download('csv');
    }

    protected function generatePassword($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * @param $user_id
     * @return null / patient object
     */
    public function deleteImage($user_id)
    {
        $patient = $this->userProfileRepository->find($user_id);
        $patient->image = null;
        $patient->save();
    }

    protected function uploadFile($file)
    {
        $s3 = \Storage::disk('local');
        $time = time();
        $filePath = 'public/assets/clinic/' .$time.'-'. $file->getClientOriginalName();
        $url = '/assets/clinic/' .$time.'-'. $file->getClientOriginalName();
        $result = $s3->put($filePath, file_get_contents($file),'public');
        if($result)
        {
            return $url;
        } 
    }
}