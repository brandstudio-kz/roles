<?php

namespace BrandStudio\Roles\Traits;

trait HasRoles
{
    use HasPermissions;

    public function roles()
    {
        return $this->belongsToMany(config('roles.role_class'), 'role_target', 'target_id', 'role_id');
    }

    public function hasRole(string $key) : bool
    {
        return $this->roles()->where('key', $key)->exists();
    }

    public function hasRoles(array $roles) : bool
    {
        return $this->roles()->whereIn('key', $roles)->count() == count($roles);
    }

    public function hasAnyRole(array $roles) : bool
    {
        return $this->roles()->whereIn('key', $roles)->exists();
    }

    public function setRole(string $key)
    {
        $role = config('roles.role_class')::where('key', $key)->first();
        if ($role) {
            $this->roles()->sync($role);
        }
    }

}
