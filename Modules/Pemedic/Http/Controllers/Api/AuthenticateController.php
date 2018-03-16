<?php

namespace Modules\Pemedic\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Modules\Pemedic\Entities\User;
use Modules\Pemedic\Entities\UserProfile;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Pemedic\Service\AuthService;
use Hash;
use Carbon\Carbon;
use Auth;
use Modules\Pemedic\Http\Transformer\UserTransformer;
use Modules\Pemedic\Http\Requests\Auth\RegisterRequest;
use Modules\Pemedic\Http\Requests\Auth\ChangePasswordRequest;
use Modules\Pemedic\Http\Requests\Auth\LoginRequest;
use Modules\Pemedic\Http\Requests\Auth\ForgotPasswordRequest;
class AuthenticateController extends AdminBaseController
{
    protected $auService; 


    public function __construct(AuthService $auService)
    {
         $this->auService = $auService;
    }
    /**
     * @SWG\Get(
     *   path="/members/getLogout",
     *   description="",
     *   summary="",
     *   operationId="api.members.getLogout",
     *   produces={"application/json"},
     *   tags={"Authenticate"},
     *   @SWG\Response(response=401, description="unauthorized"),
     *   @SWG\Response(response=200, description="Success"),
     *   security={
     *       {"api_key": {}}
     *   }
     * )
     */
    public function getLogout(Request $request)
    {
        $user = Auth::guard('api')->user();
        $user->token()->revoke();
        return response([
                    'data' => [
                    'message'   =>  'Logout success'
                    ],
            ],Response::HTTP_OK);
    }
    /**
     * @SWG\Post(
     *   path="/members/postLogin",
     *   description="<ul>
     *     <li>email : string (required)</li>
     *     <li>password : string (required)</li></ul>",
     *   summary="Login",
     *   operationId="api.members.postLogin",
     *   produces={"application/json"},
     *   tags={"Authenticate"},
     *   @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Target customer.",
     *     required=true,
     *    @SWG\Schema(ref="#/definitions/Login")
     *   ),
     *   @SWG\Response(response=101, description="Wrong email or password"),
     *   @SWG\Response(response=102, description="You need to confirm your account"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     */
    public function postLogin(LoginRequest $request,UserTransformer $userTransformer)
    {
        $user = User::where('email',$request->email)->first();
        if(isset($user) && !empty($user)){
            if (Hash::check($request->password, $user->password))
            {
                if($user->hasRoleId(5) && $user->status == 1)
                {
                    $token = $user->createToken('Login Token')->accessToken;
                    $item = $user->withAccessToken($token);

                    return response([
                        'data' => [
                        'message'   =>  'Login Success',
                        'token'   =>  $token,
                        'user'  => $userTransformer->transform($user),
                        ],
                    ],Response::HTTP_OK);
                }  
            }
        }
        return response([
                        'error' => [
                        'message'   =>  'Wrong email or password'],
                    ],Response::HTTP_OK);
    }
    /**
     * @SWG\Post(
     *   path="/members/postRegister",
     *   description="<ul>
     *     <li>email : string (required)</li>
     *     <li>password : string (required)</li>
     *     <li>name : string (required)</li></ul>",
     *   summary="View",
     *   operationId="api.v1.customers.postRegister",
     *   produces={"application/json"},
     *   tags={"Authenticate"},
     *   @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Target customer.",
     *     required=true,
     *    @SWG\Schema(ref="#/definitions/Register")
     *   ),
     *   @SWG\Response(response=103, description="The email has already been taken"),
     *   @SWG\Response(response=104, description="Send mail error"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     *
     */
    public function postRegister(RegisterRequest $request)
    {
        $user = User::where('email',$request->email)->first();
        // $message = 'User name: '. $request->email . ' / Password: '. $this->generatePassword();
        $password = $this->generatePassword();
        $message = $request->email . ' , '. $password;
        if(isset($user) && !empty($user)){
            $userProfile = UserProfile::where('user_id',$user->id)->where('phone',$request->phone)->first();
            if(isset($userProfile) && !empty($userProfile)){
                if($user->status == 0)
                {
                    $user->status = 1;
                    $user->save();
                    $type = $this->auService->sendSMS($message,$request->phone);
                    if($type == false){
                        return response([
                                'error' => [
                                'message'   =>  'Send SMS error'],
                            ],Response::HTTP_OK);

                    }
                    else{
                        return response([
                                'data' => ['message'   =>  'We sent you an user name and password. Check your SMS'],
                            ],Response::HTTP_OK);
                    }
                }
                return response([
                        'error' => [
                        'message'   =>  'The email and phone number has already been taken.'],
                    ],Response::HTTP_OK);
            }else{
                return response([
                        'error' => [
                        'message'   =>  'The email has already been taken.'],
                    ],Response::HTTP_OK);
            }
            
        }
        else{
            $userProfile = UserProfile::where('phone',$request->phone)->first();
            if(isset($userProfile) && !empty($userProfile)){
                return response([
                        'error' => [
                        'message'   =>  'The phone number has already been taken.'],
                    ],Response::HTTP_OK);
            }

            $type = $this->auService->registerNewUser($message,$request,$password);
            if($type == false){
                return response([
                        'error' => [
                        'message'   =>  'Send SMS error'],
                    ],Response::HTTP_OK);

            }
            else{
                return response([
                        'data' => ['message'   =>  'We sent you an user name and password. Check your SMS'],
                    ],Response::HTTP_OK);
            }
        }
    }
    /**
     * @SWG\Post(
     *   path="/members/postForgotPassword",
     *   description="<ul><li>email : string (required)</li></ul>",
     *   summary="View",
     *   operationId="api.v1customers.postForgotPassword",
     *   produces={"application/json"},
     *   tags={"Authenticate"},
     *   @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Target customer.",
     *     required=true,
     *    @SWG\Schema(ref="#/definitions/ForgotPassword")
     *   ),
     *   @SWG\Response(response=104, description="Send mail error"),
     *   @SWG\Response(response=108, description="We can't find a user with that e-mail address"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     *
     */
    public function postForgotPassword(ForgotPasswordRequest $request)
    {
        $user = User::where('email',$request->email)->first();
        $newPassword = $this->generatePassword();
        $message = 'New Password: '. $newPassword;
        if(isset($user) && !empty($user)){
            $userProfile = UserProfile::where('user_id',$user->id)->first();
            if(isset($userProfile) && !empty($userProfile)){
                $type = $this->auService->sendSMS($message,$userProfile->phone);
                if($type == false){
                    return response([
                            'error' => [
                            'message'   =>  'Send SMS error'],
                        ],Response::HTTP_OK);

                }
                else{
                    $user->password = Hash::make($newPassword);
                    $user->save();
                    return response([
                            'data' => ['message'   =>  'We sent you an new password. Check your SMS'],
                        ],Response::HTTP_OK);
                }
            }
        }
        return response([
                        'error' => [
                        'message'   =>  "We can't find a user with that e-mail address"],
                    ],Response::HTTP_OK);
    }

    /**
     * @SWG\Post(
     *   path="/members/postChangePassword",
     *   description="<ul>
     *     <li>currentPassword : string (required)</li>
     *     <li>newPassword : string (required)</li></ul>",
     *   summary="View",
     *   operationId="api.members.members.postChangePassword",
     *   produces={"application/json"},
     *   tags={"Authenticate"},
     *   @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Target customer.",
     *     required=true,
     *    @SWG\Schema(ref="#/definitions/ChangePassword")
     *   ),
     *   @SWG\Response(response=105, description="Current password incorrect"),
     *   @SWG\Response(response=106, description="Account does not exist"),
     *   @SWG\Response(response=500, description="internal server error"),
     *   security={
     *       {"api_key": {}}
     *   }
     * )
     *
     */
    public function postChangePassword(ChangePasswordRequest $request)
    {
        $password             = !empty($request->currentPassword) ? $request->currentPassword : false;
        $newPassword             = !empty($request->newPassword) ? $request->newPassword : false;
        $customer = Auth::guard('api')->user();

        if(isset($customer) && !empty($customer))
        {
            if (Hash::check($request->currentPassword, $customer->password))
            {
                $customer->password = Hash::make($request->newPassword);
                $customer->save();

                return response([
                    'data' => [
                        'message' => "Change Password Success"],
                ],Response::HTTP_OK);

            }
            else
            {
                    return response([
                    'error' => [
                    'message' => "Current password incorrect"],
                ],Response::HTTP_OK);
            }
        }
        return response([
                'error' => [
                'message' => "Account does not exist"],
            ],Response::HTTP_OK);

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
}
