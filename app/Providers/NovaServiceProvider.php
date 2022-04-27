<?php

namespace App\Providers;

use App\Nova\Dashboards\Main;
use App\Nova\Metrics\Users\AverageReturns;
use App\Nova\Metrics\Users\NewUsers;
use App\Nova\Metrics\Users\UsersLoggedInPerDay;
use App\Nova\Metrics\Users\UsersPerDay;
use App\Nova\Metrics\Users\UsersReturnedToday;
use App\Nova\User;
use DigitalCreative\CollapsibleResourceManager\CollapsibleResourceManager;
use DigitalCreative\CollapsibleResourceManager\Resources\Group;
use DigitalCreative\CollapsibleResourceManager\Resources\InternalLink;
use DigitalCreative\CollapsibleResourceManager\Resources\LensResource;
use DigitalCreative\CollapsibleResourceManager\Resources\NovaResource;
use DigitalCreative\CollapsibleResourceManager\Resources\TopLevelResource;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Illuminate\Http\Request;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::mainMenu(function (Request $request) {
            return [
                MenuSection::dashboard(Main::class),

                MenuSection::make('Resources', [
                    MenuItem::resource(User::class),
                ])->icon('home')->collapsable(),
                MenuSection::make('Roles & Permissions', [
                    MenuItem::make('Roles')
                        ->path('/resources/roles'),
                    MenuItem::make('Permissions')
                        ->path('/resources/permissions')
                ])->icon('lock-closed')->collapsable(),
            ];
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return $user->is_admin;
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            // new Help,
            (new UsersPerDay())->width("1/3"),
            (new NewUsers())->help('This is all new users in the database.')->width("1/3"),
            (new UsersReturnedToday())->width("1/3"),
            (new AverageReturns())->width("1/3"),
            (new UsersLoggedInPerDay())->width("1/3"),
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new Main(),
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            \Vyuldashev\NovaPermission\NovaPermissionTool::make(),
            // new CollapsibleResourceManager([
            //     'disable_default_resource_manager' => true, // default
            //     'navigation' => [
            //         TopLevelResource::make([
            //             'resources' => [
            //                 Group::make([
            //                     'label' => 'Control',
            //                     'expanded' => true,
            //                     'resources' => [
            //                         NovaResource::make(\App\Nova\AppSetting::class)->canSee(function ($request) {
            //                             return in_array("settings_access", $request->user()->getAllPermissions()->pluck('name')->all());
            //                         })->label("App Settings")->icon('<svg aria-hidden="true" height="16" width="24" focusable="false" data-prefix="fas" data-icon="wrench" class="svg-inline--fa fa-wrench fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M507.73 109.1c-2.24-9.03-13.54-12.09-20.12-5.51l-74.36 74.36-67.88-11.31-11.31-67.88 74.36-74.36c6.62-6.62 3.43-17.9-5.66-20.16-47.38-11.74-99.55.91-136.58 37.93-39.64 39.64-50.55 97.1-34.05 147.2L18.74 402.76c-24.99 24.99-24.99 65.51 0 90.5 24.99 24.99 65.51 24.99 90.5 0l213.21-213.21c50.12 16.71 107.47 5.68 147.37-34.22 37.07-37.07 49.7-89.32 37.91-136.73zM64 472c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24z"></path></svg>'),
            //                     ],
            //                 ]),
            //             ],
            //         ]),
            //         TopLevelResource::make([
            //             'label' => 'Users',
            //             'icon' => '<svg style="width:24px;height:24px" viewBox="0 0 24 24">
            //                 <path fill="currentColor" d="M12,5A3.5,3.5 0 0,0 8.5,8.5A3.5,3.5 0 0,0 12,12A3.5,3.5 0 0,0 15.5,8.5A3.5,3.5 0 0,0 12,5M12,7A1.5,1.5 0 0,1 13.5,8.5A1.5,1.5 0 0,1 12,10A1.5,1.5 0 0,1 10.5,8.5A1.5,1.5 0 0,1 12,7M5.5,8A2.5,2.5 0 0,0 3,10.5C3,11.44 3.53,12.25 4.29,12.68C4.65,12.88 5.06,13 5.5,13C5.94,13 6.35,12.88 6.71,12.68C7.08,12.47 7.39,12.17 7.62,11.81C6.89,10.86 6.5,9.7 6.5,8.5C6.5,8.41 6.5,8.31 6.5,8.22C6.2,8.08 5.86,8 5.5,8M18.5,8C18.14,8 17.8,8.08 17.5,8.22C17.5,8.31 17.5,8.41 17.5,8.5C17.5,9.7 17.11,10.86 16.38,11.81C16.5,12 16.63,12.15 16.78,12.3C16.94,12.45 17.1,12.58 17.29,12.68C17.65,12.88 18.06,13 18.5,13C18.94,13 19.35,12.88 19.71,12.68C20.47,12.25 21,11.44 21,10.5A2.5,2.5 0 0,0 18.5,8M12,14C9.66,14 5,15.17 5,17.5V19H19V17.5C19,15.17 14.34,14 12,14M4.71,14.55C2.78,14.78 0,15.76 0,17.5V19H3V17.07C3,16.06 3.69,15.22 4.71,14.55M19.29,14.55C20.31,15.22 21,16.06 21,17.07V19H24V17.5C24,15.76 21.22,14.78 19.29,14.55M12,16C13.53,16 15.24,16.5 16.23,17H7.77C8.76,16.5 10.47,16 12,16Z" /></svg>',
            //             'linkTo' => NovaResource::make(\App\Nova\User::class),
            //             'resources' => [
            //                 NovaResource::make(\App\Nova\User::class)->label("All Users"),
            //                 LensResource::make(
            //                     \App\Nova\User::class,
            //                     \App\Nova\Lenses\Users\AdminUsers::class
            //                 )->label("Admin Users"),
            //                 NovaResource::make(\App\Nova\UserLog::class)->label("Logins"),
            //                 NovaResource::make(\App\Nova\UserPercentageLog::class)->label("Percentage Logins"),
            //                 NovaResource::make(\App\Nova\UserRegistrationLog::class)->label("Registrations"),
            //                 Group::make([
            //                     'label' => 'Access Control',
            //                     'expanded' => false,
            //                     'resources' => [
            //                         InternalLink::make([
            //                             'label' => 'Roles',
            //                             'target' => '_self',
            //                             'path' => '/resources/roles',
            //                         ]),
            //                         InternalLink::make([
            //                             'label' => 'Permission',
            //                             'target' => '_self',
            //                             'path' => '/resources/permissions',
            //                         ]),
            //                     ],
            //                 ])->canSee(function ($request) {
            //                     return in_array("access_control", $request->user()->getAllPermissions()->pluck('name')->all());
            //                 }),
            //             ],
            //         ])->canSee(function ($request) {
            //             return in_array("users_access", $request->user()->getAllPermissions()->pluck('name')->all());
            //         }),
            //     ],
            // ]),
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
