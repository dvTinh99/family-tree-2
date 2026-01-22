<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(AuthRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $access_token = JWTAuth::fromUser($user);
            $refresh_token = auth('api')->setTTL(43200)->claims(['is_refresh_token' => true])->login($user);
            DB::commit();
            return $this->responseSuccess([
                'user'           => $user,
                'access_token'   => $access_token,
                'refresh_token'  => $refresh_token,
                'token_type'     => 'bearer',
            ], 'register success');
        } catch (JWTException $e) {
            DB::rollBack();
            return $this->responseError([], $e->getMessage());
        }
    }

    public function login(AuthRequest $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (auth()->validate($credentials)) {
                // credentials are valid
                $access_token = JWTAuth::attempt($credentials);
                Log::debug('token', [$access_token]);
                $user = auth('api')->setToken($access_token)->user();
                ['refresh_token' => $refresh_token] = $this->getTokens($user);
                return $this->responseSuccess([
                    'user'           => $user,
                    'access_token'   => $access_token,
                    'refresh_token'  => $refresh_token,
                    'token_type'     => 'bearer',
                ], 'register success');
            } else {
                return $this->responseError([
                    'message' => 'Username or password incorrect'
                ], 'login fail');
            }
        } catch (JWTException $e) {
            Log::debug('$JWTException', [$e->getMessage()]);
            return $this->responseError([], $e->getMessage());
        } catch (Exception $e) {
            Log::debug('$Exception', [$e->getMessage()]);
        }
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (JWTException $e) {
            return $this->responseError([], 'Failed to logout, please try again');
        }

        return $this->responseSuccess([], 'logout success');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user(); // nếu bạn dùng API
        $user = User::where('google_id', $googleUser->id)->first();

        if (! $user) {
            $user = User::create([
                'name'      => $googleUser->name,
                'email'     => $googleUser->email,
                'google_id' => $googleUser->id,
                'password'  => bcrypt(Str::random(16)),
            ]);
        }

        ['access_token' => $access_token, 'refresh_token' => $refresh_token] = $this->getTokens($user);
        $url = url(env('FE_URL')) . "?access_token=$access_token&refresh_token=$refresh_token";
        return redirect($url);
    }

    private function getTokens(User $user) {
        $access_token = JWTAuth::fromUser($user);
        $refresh_token = auth('api')->setTTL(43200)->claims(['is_refresh_token' => true])->login($user);
        return [
            'access_token' => $access_token,
            'refresh_token' => $refresh_token
        ];
    }
}