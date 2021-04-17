<?php

namespace App\Services\AllServices;

use App\Models\User;
use App\Models\UserLog;
use Carbon\Carbon;
use Exception;

class General
{

    public static function logUserForTheDay(User $user)
    {
        if (!$user->approved) {
            throw new Exception("Account Blocked", 401);
        }


        // Log User for the day
        date_default_timezone_set('Africa/Lagos');
        $date = date('m/d/Y', time());
        $dateTime = Carbon::parse($date)->toDateTimeString();

        $log = $user->userLogs->where('created_at', '>=', $dateTime)->first();
        if (!$log) {
            if ($user->created_at < $dateTime && !$user->is_admin) {
                $newLog = new UserLog();
                $newLog->user_id = $user->id;
                $newLog->save();
            }
        }
    }
}

return new General;
