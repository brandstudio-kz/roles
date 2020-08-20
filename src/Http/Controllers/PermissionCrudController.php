<?php

namespace BrandStudio\Roles\Http\Controllers;

use BrandStudio\Roles\Http\Requests\PermissionRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class PermissionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel(config('permissions.permission_class'));
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/permission');
        $this->crud->setEntityNameStrings(trans_choice('brandstudio::roles.permissions', 1), trans_choice('brandstudio::roles.permissions', 2));

        if (!config('permissions.allow_permission_create')) {
            $this->crud->denyAccess('create');
        }
        if (!config('permissions.allow_permission_update')) {
            $this->crud->denyAccess('update');
        }
        if (!config('permissions.allow_permission_delete')) {
            $this->crud->denyAccess('delete');
        }
    }

    public function setupListOperation()
    {
        $this->crud->addColumn([
            'name' => 'key',
            'label' => trans('brandstudio::roles.name'),
            'type' => 'text',
        ]);
    }
}
