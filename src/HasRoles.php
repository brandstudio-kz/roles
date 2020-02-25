<?php

namespace BrandStudio\Roles;

trait HasRoles
{

    public function roles()
    {
        return $this->hasMany(config('roles.role_class'), 'role_target', $this->primaryKey, 'role_id');
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

}
