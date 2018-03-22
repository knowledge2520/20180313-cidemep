<?php
/**
 * @description: Deal Service class execute the service logic CMS
 */
namespace Modules\Pemedic\Services;

use Modules\Pemedic\Repositories\ClinicProfileRepository;
use Modules\Pemedic\Repositories\ActivationRepository;
use Modules\User\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Modules\Pemedic\Entities\ClinicProfile;
use Modules\Pemedic\Mail\WelcomeMail;
use Mail;
use Illuminate\Support\Facades\Storage;

class ClinicService {

    /**
     * @var ClinicProfileRepository
     */
    private $clinicRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

     /**
     * @var ActivationRepository
     */
    private $activationRepository;


    public function __construct(ClinicProfileRepository $clinicRepository,UserRepository $userRepository,ActivationRepository $activationRepository) {
        $this->clinicRepository         = $clinicRepository;
        $this->userRepository           = $userRepository;
        $this->activationRepository     = $activationRepository;
    }


    /**
     * create clinic function 
     * @param array $data
     * @param $request
     * @return null / user object
     */
    public function create($data = array(),$request)
    {
        
        $password = rand(100000,1000000);
        
        // create clinic in user table
        $user = $this->clinicRepository->createUser([
            'email'     => $data['email'],
            'password'  => $password,
            'clinic_name'  => $data['clinic_name'],
        ]);
        if (!empty($user)) {

            // send mail user
            Mail::to($data['email'])->send(new WelcomeMail($user,$password));

            // assign role
            $user->roles()->attach(config('asgard.userprofile.config.roles.clinic'));

            $data['image'] = null;
            if(!empty($request->file('image')))
            {
                $file = $request->file('image');
                $data['image'] = $this->uploadFile($request->file('image'));
            }
            // create clinicProfile
            $this->clinicRepository->create([
                'user_id'        => $user->id,
                'clinic_name'    => $data['clinic_name'],
                'phone'          => $data['phone'],
                'vip_phone'      => $data['vip_phone'],
                'address'        => $data['address'],
                'map'            => $data['map'],
                'word_time'      => $data['word_time'],
                'website'        => $data['website'],
                'issurance'      => $data['issurance'],
                'image'          => $data['image'],
            ]);
        }

        // when user is created from CMS, we inactivate account as default
        $this->clinicRepository->activateUser($user);
        return $user;
    }

    /**
     * update clinic function 
     * @param ClinicProfile $clinic
     * @param array $data
     * @param $request
     * @return null / clinic object
     */
    public function update(ClinicProfile $clinic,$data = array(),$request)
    {
        $this->userRepository->update($clinic->user,$data);
        $activation =  $this->activationRepository->findByAttributes(['user_id'=>$clinic->user->id]);
        if(!empty($activation))
        {
            $this->activationRepository->update($activation,$data);
        }
        if(!empty($request->file('image')))
        {
            $file = $request->file('image');
            $data['image'] = $this->uploadFile($request->file('image'));
        }
        return $this->clinicRepository->update($clinic,$data);
    }

    /**
     * delete clinic function 
     * @param clinic_id
     */
    public function deleteImage($clinic_id)
    {
        $clinic = $this->clinicRepository->find($clinic_id);
        $clinic->image = null;
        $clinic->save();
    }


    /**
     * upload file clinic function 
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
}