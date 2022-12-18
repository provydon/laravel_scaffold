<?php

namespace App\Nova\Metrics\Users;

use App\Models\User;
use App\Models\UserLog;
use App\Models\UserPercentageLog;
use Carbon\Carbon;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class AverageReturns extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function name()
    {
        return 'Average Percentage Of Returning Users Per Day';
    }

    public function calculate(NovaRequest $request)
    {
        date_default_timezone_set('Africa/Lagos');
        $date = date('m/d/Y', time());
        $dateTime = Carbon::parse($date)->toDateTimeString();

        // Calculate Percentage of Users Logged in today
        $logs = UserLog::where('created_at', '>=', $dateTime)->count();
        $users = User::all()->count();
        $returned_users = ($logs / $users) * 100;

        // Log Percentages
        $log = UserPercentageLog::where('created_at', '>=', $dateTime)->first();
        if (! $log) {
            $newLog = new UserPercentageLog;
            $newLog->percentage = $returned_users;
            $newLog->number = $logs;
            $newLog->total = $users;
            $newLog->save();
        } else {
            $new = ($logs / $log->total) * 100;
            $log->percentage = $new;
            $log->number = $logs;
            $log->save();
            $returned_users = $new;
        }

        // dd($returned_users);
        return $this->result($returned_users)->allowZeroResult()->suffix('%')->withoutSuffixInflection();
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            // 30 => __('30 Days'),
            // 60 => __('60 Days'),
            // 365 => __('365 Days'),
            // 'TODAY' => __('Today'),
            // 'MTD' => __('Month To Date'),
            // 'QTD' => __('Quarter To Date'),
            // 'YTD' => __('Year To Date'),
        ];
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'users-average-returns';
    }
}
