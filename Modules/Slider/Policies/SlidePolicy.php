<?php

namespace Modules\Slider\Policies;

use Modules\RolePermissions\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class SlidePolicy
{
    use HandlesAuthorization;

    public function manage($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_SLIDES)) return true;
    }
}
