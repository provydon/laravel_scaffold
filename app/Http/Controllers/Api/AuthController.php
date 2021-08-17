<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\User as ResourcesUser;
use App\Models\User;
use App\Services\AllServices\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = $this->authenticate($request->email, $request->password);
        $data = [
            "token" => $user->createToken(config('app.jwt_token_name'))->accessToken,
            "user" => new ResourcesUser($user),
        ];

        return Helper::apiRes("successfully logged in", $data);
    }

    public function logout()
    {
        $user = Auth::user()->token();
        $user->revoke();

        return Helper::apiRes("User logged out");
    }

    /**
     * Register api
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try {
            //code...
            $user = new User;
            $user->name = $request->name ? $request->name : ucwords($request->first_name) . ' ' . ucwords($request->last_name);
            $user->email = $request->email;
            $user->username = $request->username;
            $user->phone = $request->phone;
            $user->password = bcrypt($request->password);
            $user->save();
        } catch (\Throwable $th) {
            return Helper::apiRes($th->getMessage(), [], false, 401);
        }

        if ($request->image != null) {
            try {
                $path = FileService::storeFile($request->file('image'), 'user_images');
            } catch (\Throwable $th) {
                return Helper::apiRes($th->getMessage(), [], false, 500);
            }

            if ($path) {
                $user->image = $path;
            }
            $user->save();
        }

        $user = $this->authenticate($request->email, $request->password);
        $data = [
            "token" => $user->createToken(config('app.jwt_token_name'))->accessToken,
            "user" => new ResourcesUser($user),
        ];

        return Helper::apiRes("uccessfully registered", $data);
    }

    public function authenticate($email, $password)
    {
        // if user found, attempt authentication
        Auth::attempt(['email' => $email, 'password' => $password]);

        // if authentication failed
        if (!Auth::check()) {
            return Helper::apiRes("invalid login credentials", [], false, 401);
        }

        // Authentication Succeeded
        return Auth::user();
    }

    public function forgotPassword(Request $request)
    {
        Password::sendResetLink($request->all());

        return Helper::apiRes("Reset password link sent to your email");
    }
}
