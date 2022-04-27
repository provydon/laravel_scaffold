<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
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


        if (in_array("users_access", $this->permissions)) {
            $this->access = true;
        }
    }

    public function viewAny(User $user)
    {
        return in_array("users_access", $this->permissions);
    }

    public function view(User $user)
    {
        return $this->access && in_array("users_view", $this->permissions);
    }

    public function create(User $user)
    {
        return $this->access && in_array("users_create", $this->permissions);
    }

    public function update(User $user)
    {
        return $this->access && in_array("users_edit", $this->permissions);
    }

    public function delete(User $user)
    {
        return $this->access && in_array("users_delete", $this->permissions);
    }

    public function approve(User $user)
    {
        return $this->access && in_array("users_approve_disapprove", $this->permissions);
    }

    public function disapprove(User $user)
    {
        return $this->access && in_array("users_approve_disapprove", $this->permissions);
    }

    public function makeAdmin(User $user)
    {
        return $this->access && in_array("users_make_admin", $this->permissions);
    }

    public function sendNotification(User $user)
    {
        return $this->access && in_array("users_send_notification", $this->permissions);
    }
}
