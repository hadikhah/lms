<?php
namespace Modules\RolePermissions\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

class PermissionRepo
{
    public function all(): Collection
    {
        return Permission::all();
    }
}
