<?php

namespace BrandStudio\Roles\Traits;

trait HasPermissions
{

    public function permissions()
    {
        return $this->morphToMany(config('permissions.permission_class'), 'permissionable');
    }

    public function hasPermission(string $key): bool
    {
        return $this->permissions()->where('key', $key)->exists() ||
               $this->roles()->whereHas('permissions', function($query) use($key) {
                    $query->where('key', $key);
                })->exists();
    }

    public function hasPermissions(array $permissions): bool
    {
        return $this->permissions()->whereIn('key', $permissions)->count() == count($permissions);
    }

    public function hasAnyPermission(array $permissions): bool
    {
        if ($this->roles()) {
            return $this->permissions()->whereIn('key', $permissions)->exists() ||
                   $this->roles()->whereHas('permissions', function($query) use($permissions) {
                        $query->whereIn('key', $permissions);
                    })->exists();
        } else {
            return $this->permissions()->whereIn('key', $permissions)->exists();
        }

    }

    public function setPermission(string $key)
    {
        $permission = config('permissions.permission_class')::where('key', $key)->first();
        if($permission) {
            $this->permissions()->save($permission);
        }
    }
}
