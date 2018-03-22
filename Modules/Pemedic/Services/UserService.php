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
     * create users function
     * @param array $data
     * @param $role
     * @param $request
     * @return null / users object
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
        $oldUser =  $this->userRepository->findByAttributes(['email'=>$request->email]);
        if(!empty($oldUser))
        {
            if($oldUser->roles()->first()->id != config('asgard.userprofile.config.roles.clinic'))
            {
                $oldUser->roles()->attach($role);
            }
            else
            {
                return null;
            }
        }
        else
        {
            $user = $this->userRepository->addNewUser($role,$data,0);
            if(isset($data['clinic_id']) && count($data['clinic_id'])>0)
            {
                 // assign clinic
                $user->clinic()->attach($data['clinic_id']);
            }
            return $user;
        }
    }

    /**
     * update users function
     * @param User $user
     * @param array $data
     * @param request
     * @return null / user object
     */
    public function update(User $user,$data = array(),$request)
    {
        $data['dob'] = !empty($data['dob'])?date('Y-m-d', strtotime($data['dob'])):null;
        $this->userRepository->update($user,$data);
        if(isset($data['clinic_id']) && count($data['clinic_id'])>0)
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
     * export users to csv function
     * @param role_id
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

    /**
     * import patients csv function
     * @param request
     */
    public function import($request)
    {   
        if($request->hasFile('file')) {
            $items = \Excel::load($request->file('file'), function($reader) {
            })->get()->values()->toArray();
            if(count($items)>0)
            {
                $dataErrors = [];
                $dataArr = [];
                $totalSuccess = 0;
                $formatErrors =[];
                // First Validate CSV, if failed, prevent csv upload.
                foreach($items as $key=>$value) {
                    $userCsvDetail = array_values($value); 
                    $validateCsvResult = $this->validateCsvFormat($userCsvDetail);
                    if($validateCsvResult != "Valid") {
                        $formatErrors[] = "Row ".($key + 2)." : ".$validateCsvResult;
                    }
                    $validate_email = $this->userRepository->validateEmail(config('asgard.userprofile.config.roles.patient'),$userCsvDetail[0]);
                    if($validate_email)
                    {
                        $validate_phone = $this->userProfileRepository->findByAttributes(['phone'=>$userCsvDetail[1]]);
                        if(empty($validate_phone))
                        {
                            $data = [];
                            $oldUser =  $this->userRepository->findByAttributes(['email'=>$userCsvDetail[0]]);
                            if(!empty($oldUser))
                            {
                                $totalSuccess++;
                                // $oldUser->roles()->attach($role);
                            }
                            else
                            {
                                $totalSuccess++;
                                $password = $this->generatePassword();
                                $data['email']      = $userCsvDetail[0];
                                $data['password']   = Hash::make($password);
                                $data['phone']      = $userCsvDetail[1];
                                // $user = $this->userRepository->addNewUser(config('asgard.userprofile.config.roles.patient'),$data,0);
                            }
                        }
                        else
                        {
                            $formatErrors[] = "Row ".($key + 2)." : The phone has already been taken";
                            $dataErrors[] = $userCsvDetail[0];
                        }
                    }
                    else
                    {
                        $formatErrors[] = "Row ".($key + 2)." : The email has already been taken";
                        $dataErrors[] = $userCsvDetail[0];
                    }                
                }
                $dataArr['totalSuccess']    = $totalSuccess;
                $dataArr['dataErrors']      = $dataErrors;
                $dataArr['formatErrors']    = $formatErrors;
                return $dataArr;
            }
        }
        
    }

    /**
     * random password function
     * @param $length = 6
     * @return string random
     */
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
     * delete image function
     * @param $user_id
     */
    public function deleteImage($user_id)
    {
        $patient = $this->userProfileRepository->find($user_id);
        $patient->image = null;
        $patient->save();
    }

    /**
     * bulk delete service
     * @param $user_id
     */
    public function bulkDelete($user_id)
    {
        $users =  explode(',',$user_id);
        foreach ($users as $id) {
            $user = $this->userProfileRepository->find($id);
            if($user)
            {
                $user->phone = $user->phone . time();
                $user->save();

                $patient = $user->user;
                $patient->email = $patient->email . time();
                $patient->save();
                $this->userProfileRepository->destroy($user);
                $this->userRepository->destroy($user->user);
            }
        }  
    }

    /**
     * upload file users function 
     * @param $file
     * @return file $url
     */
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

    /**
     * validate field email
     * @param $dataUser
     * @return message/null
     */
    private function validateCsvFormat($dataUser) {
        // Invalidate data if missing columns
        if(sizeof($dataUser) != 2) {
            return "Import failed due to the wrong number of columns";
        }

        // Regex
        $invalidFields = [];

        if(!filter_var($dataUser[0], FILTER_VALIDATE_EMAIL)){
            array_push($invalidFields, 'Email'); 
        }
        if(!preg_match('/^[0-9]*$/', $dataUser[1])){ array_push($invalidFields, 'Phone'); }
        
        // Return true if no errors otherwise return error message
        if(count($invalidFields) == 0) {
            return "Valid";
        } else {
            return $dataUser[0]." import failed due to the following invalid fields: ".implode(", ", $invalidFields);
        }
    }
}