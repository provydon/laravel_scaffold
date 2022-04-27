<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AppSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppSettingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public $permissions = [];
    public $access = false;

    public function __construct()
    {

        $user = Auth::user();
        if (isset($user)) {
            # code...
            foreach ($user->roles as $item) {
                foreach ($item->permissions as $key => $value) {
                    array_push($this->permissions,$value->name);
                }
            }
        }


        if (in_array("settings_access", $this->permissions)) {
            $this->access = true;
        }
    }

    public function viewAny(User $user)
    {
        return in_array("settings_access", $this->permissions);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AppSetting  $appSetting
     * @return mixed
     */
    public function view(User $user, AppSetting $appSetting)
    {
        return $this->access && in_array("settings_view", $this->permissions);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->access && in_array("settings_create", $this->permissions);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AppSetting  $appSetting
     * @return mixed
     */
    public function update(User $user, AppSetting $appSetting)
    {
        return $this->access && in_array("settings_edit", $this->permissions);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AppSetting  $appSetting
     * @return mixed
     */
    public function delete(User $user, AppSetting $appSetting)
    {
        return $this->access && in_array("settings_delete", $this->permissions);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AppSetting  $appSetting
     * @return mixed
     */
    public function restore(User $user, AppSetting $appSetting)
    {
        return $this->access && in_array("settings_restore", $this->permissions);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AppSetting  $appSetting
     * @return mixed
     */
    public function forceDelete(User $user, AppSetting $appSetting)
    {
        return $this->access && in_array("settings_force_delete", $this->permissions);
    }
}
