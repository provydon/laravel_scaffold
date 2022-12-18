<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\Users\AverageReturns;
use App\Nova\Metrics\Users\NewUsers;
use App\Nova\Metrics\Users\UsersLoggedInPerDay;
use App\Nova\Metrics\Users\UsersPerDay;
use App\Nova\Metrics\Users\UsersReturnedToday;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            // new Help,
            (new UsersPerDay())->width('1/3'),
            (new NewUsers())->help('This is all new users in the database.')->width('1/3'),
            (new UsersReturnedToday())->width('1/3'),
            (new AverageReturns())->width('1/3'),
            (new UsersLoggedInPerDay())->width('1/3'),
        ];
    }
}
