<?php 
namespace Modules\Pemedic\Service;

use Log;
use Modules\Pemedic\Entities\User;
use Modules\Pemedic\Entities\UserRole;
use Hash;
use Modules\Pemedic\Repositories\UserProfileRepository;
use Modules\Pemedic\Repositories\UserRepository;
class AuthService
{
    /**
     * @var UserProfileRepository
     */
    private $userProfileRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    
    public function __construct(UserProfileRepository $userProfileRepository,UserRepository $userRepository)
    {
        $this->userProfileRepository = $userProfileRepository;
        $this->userRepository = $userRepository;
    }   

    public function registerNewUser($message,$request,$password)
    {
        try{
            $allRequest = $request->all();
            $allRequest['password'] = Hash::make($password);
            $this->setupSendSMS($message, $request->phone); 
            $this->userRepository->addNewUser(5,$allRequest,1);
            return true;
        }
        catch(\Exception $e){
            return false;
        }
    }
    public function sendSMS($message, $phone)
    {
        try{
            $this->setupSendSMS($message, $phone);
            return true;
        }
        catch(\Exception $e){
            return false;
        }
        
    }
    protected function setupSendSMS($message,$toNumber) {
        $APIKey= env('NEXMO_KEY');
        $SecretKey= env('NEXMO_SECRET');
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $url = 'https://rest.nexmo.com/sms/json?' . http_build_query(
            [
              'api_key' =>  $APIKey,
              'api_secret' => $SecretKey,
              'to' => $toNumber,
              'from' => 'Pemedic',
              'type'=>'unicode',
              'text' => $message,

            ]
        );
        $homepage = file_get_contents($url,false, stream_context_create($arrContextOptions));
        $decoded_response = json_decode($homepage, true);

        //echo json_encode($decoded_response );exit;
        Log::info('You sent ' . $decoded_response['message-count'] . ' messages.');

        foreach ( $decoded_response['messages'] as $message ) {
            if ($message['status'] == 0) {
               Log::info("Success " . $message['message-id'] . " to number:" . $toNumber);
            } else {
               Log::info("Error {$message['status']} {$message['error-text']}" . " to number:" . $toNumber);
            }
        }
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
    protected function getToken()
    {
        return hash_hmac('sha256', str_random(6), config('app.key'));
    }
    protected function addNewUser($request)
    {
        $user = new User();
        $user->email = $request->email;
        $user->password = Hash::make($this->generatePassword());
        $user->status = 1;
        $user->save();
        $userRole = new UserRole();
        $userRole->user_id = $user->id;
        $userRole->role_id = 5;
        $userRole->save();
        return $user;
    }
}