<?php

namespace App\Services\AllServices;

use App\Models\User;
use App\Models\UserLog;
use Exception;

class General
{
    public static function logUserForTheDay(User $user)
    {
        if (isset($user->approved)) {
            if (! $user->approved) {
                throw new Exception('Account Blocked', 401);
            }
        }

        // Log User for the day
        if (isset($user->userLogs)) {
            $dateTime = now()->startOfDay()->toDateTimeString();
            $log = $user->userLogs->where('created_at', '>=', $dateTime)->first();
            if (! $log) {
                if ($user->created_at < $dateTime && ! $user->is_admin) {
                    $newLog = new UserLog();
                    $newLog->user_id = $user->id;
                    $newLog->save();
                }
            }
        }
    }
}

return new General;
