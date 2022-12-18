<?php

namespace App\Nova\Actions\Users;

use App\Events\NotifyUser;
use App\Models\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class MakeUserAnAdmin extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $user) {
            $user->is_admin = true;
            $user->save();

            $roles = Role::count();

            for ($i = 1; $i <= $roles; $i++) {
                $user->roles()->detach($i);
            }

            $user->roles()->attach($fields->type);

            // Send Notifications
            event(new NotifyUser($user, 'Admin Approval', 'Your account has made an admin, login to use the Platform.'));
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        $roles = Role::all();
        $roles_array = [];

        foreach ($roles as $key => $role) {
            $roles_array[$role->id] = ucfirst($role->name);
        }

        return [
            Select::make('Admin Type', 'type')->options($roles_array)
                ->creationRules('required')
                ->updateRules('required'),
        ];
    }
}
