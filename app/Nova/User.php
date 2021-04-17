<?php

namespace App\Nova;

use App\Nova\Metrics\Users\NewUsers;
use App\Nova\Metrics\Users\UsersPerDay;
use App\Nova\Metrics\Users\UsersReturnedToday;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Vyuldashev\NovaPermission\PermissionBooleanGroup;
use Vyuldashev\NovaPermission\RoleBooleanGroup;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\User::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public function title()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'email',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Gravatar::make()->maxWidth(50),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),

            Boolean::make('Is Admin', 'is_admin'),

            RoleBooleanGroup::make('Roles'),

            PermissionBooleanGroup::make('Permissions'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [
            (new NewUsers())->help('This is all new users in the database.')->width("1/3"),
            (new UsersPerDay())->help('Trend of  all new users in the database.')->width("1/3"),
            (new UsersReturnedToday())->width("1/3"),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new Filters\FilterDate
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [
            new Lenses\Users\AdminUsers,
        ];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            (new Actions\Users\EmailUser)
                ->canSee(function ($request) {
                    return in_array("users_edit", $request->user()->getAllPermissions()->pluck('name')->all());
                })
                ->confirmButtonText('Send')
                ->showOnTableRow(),

            (new Actions\Users\MakeUserAnAdmin)
                ->confirmText('Are you sure you want to make this user(s) an/all Admin(s)?')
                ->confirmButtonText('Make')
                ->showOnTableRow(),

            (new Actions\Users\RemoveUserAsAdmin)
                ->confirmText('Are you sure you want to REVOME this user(s) as Admin(s)?')
                ->confirmButtonText('Revome')
                ->showOnTableRow(),
        ];
    }
}
