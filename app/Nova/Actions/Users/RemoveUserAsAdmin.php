<?php

namespace App\Nova\Actions\Users;

use App\Events\NotifyUser;
use App\Models\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class RemoveUserAsAdmin extends Action
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
            $user->is_admin = false;
            $user->save();

            $roles = Role::count();

            for ($i = 1; $i <= $roles; $i++) {
                $user->roles()->detach($i);
            }

            // Send Notifications
            event(new NotifyUser($user, 'Account Removed as Admin', 'Your account has been Account Removed as admin by the admin.'));
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}
