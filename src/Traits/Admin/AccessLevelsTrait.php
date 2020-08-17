<?php

namespace BrandStudio\Roles\Traits\Admin;

trait AccessLevelsTrait
{
    private $actions = [
        'list' => ['view', 'create', 'update', 'delete'],
        'create' => ['create'],
        'update' => ['update'],
        'delete' => ['delete'],
        'revisions' => ['update', 'delete'],
        // 'reorder' => ['create', 'update'],
        'show' => ['view', 'create', 'update', 'delete'],
        // 'clone' => ['create'],
    ];

    private function setAccessLevels()
    {

        if (!$this->crud)
        {
            abort(404, 'class not found');
        }

        $user = backpack_user();

        foreach($this->actions as $access => $actions)
        {
            $permissions = $this->getPermissions($actions);

            if ($user->hasAnyPermission($permissions)) {
                $this->crud->allowAccess($access);
            } else {
                if($access == 'create') {
                    $this->crud->denyAccess('reorder');
                }
                $this->crud->denyAccess($access);
            }
        }
    }

    private function getPermissions(array $actions) : array
    {
        return config('permissions.permission_class')::getNamesByModelAndActions(class_basename($this->crud->model), $actions);
    }
}
