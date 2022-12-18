<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\User as ResourcesUser;
use App\Services\AllServices\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return Helper::apiRes('Logged in user', new ResourcesUser($user));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if ($request->image != null) {
            $path = null;

            try {
                $path = FileService::storeFile($request->file('image'), 'avatars');
            } catch (\Throwable $th) {
                return Helper::apiRes($th->getMessage(), [], false, 500);
            }

            if ($path) {
                if ($user->image) {
                    try {
                        $path = FileService::deleteFile($user->image);
                    } catch (\Throwable $th) {
                        return Helper::apiRes($th->getMessage(), [], false, 500);
                    }
                }
                $user->image = $path;
                $user->profile_photo_path = $path;
            }
        }

        if ($request->first_name) {
            $user->first_name = $request->first_name;
        }

        if ($request->last_name) {
            $user->last_name = $request->last_name;
        }

        if ($request->phone) {
            $user->phone = $request->phone;
        }

        $user->save();

        return Helper::apiRes('User Updated', new ResourcesUser($user));
    }
}
