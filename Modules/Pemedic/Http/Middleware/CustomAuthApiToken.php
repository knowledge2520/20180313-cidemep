<?php
namespace Modules\Pemedic\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\User\Repositories\UserTokenRepository;
use Modules\User\Http\Middleware\AuthorisedApiToken;
use Illuminate\Contracts\Auth\Guard;
use Modules\User\Guards\Sentinel;

class CustomAuthApiToken {

    /**
     * @var UserTokenRepository
     */
    private $userToken;

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $sentinel;

    public function __construct(Sentinel $sentinel, UserTokenRepository $userTokenRepository) {
        $this->userToken = $userTokenRepository;
        $this->sentinel = $sentinel;
    }

    public function handle(Request $request, \Closure $next) {

        if ($request->header('Authorization') === null) {
            return response()->json([
                'success' => false,
                'error' => [
                    'description' => 'Unauthorized',
                    'error_code' => 401,
                    'error_messages' => 'Unauthorized'
                ]
            ], 401, []);
        }

        if ($this->isValidToken($request->header('Authorization')) === false) {
            return response()->json([
                'success' => false,
                'error' => [
                    'description' => 'Unauthorized',
                    'error_code' => 401,
                    'error_messages' => 'Unauthorized'
                ]
            ], 401, []);
        }

        $user = $this->getUser($request->header('Authorization'));

        $this->sentinel->setUser($user);

        return $next($request);
    }

    private function isValidToken($token)
    {
        $found = $this->userToken->findByAttributes(['access_token' => $this->parseToken($token)]);

        if ($found === null) {
            return false;
        }

        return true;
    }

    private function parseToken($token)
    {
        return str_replace('Bearer ', '', $token);
    }

    private function getUser($token) {
        $userToken = $this->userToken->findByAttributes(['access_token' => $this->parseToken($token)]);

        return $userToken->user()->first();
    }
}