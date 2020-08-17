<?php

namespace BrandStudio\Roles\Http\Controllers;

use BrandStudio\Roles\Http\Requests\RoleRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class RoleCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel(config('roles.role_class'));
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/role');
        $this->crud->setEntityNameStrings(trans_choice('brandstudio::roles.roles', 1), trans_choice('brandstudio::roles.roles', 2));

        if (!config('roles.allow_create')) {
            $this->crud->denyAccess('create');
        }
        if (!config('roles.allow_delete')) {
            $this->crud->denyAccess('delete');
        }
    }

    protected function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'row_number',
                'label' => '#',
                'type' => 'row_number'
            ],
            [
                'name' => 'name',
                'label' => trans('brandstudio::roles.name'),
                'type' => 'text'
            ],
        ]);
        $this->crud->addColumns(config('roles.crud_extra_columns'));

        $this->crud->addColumn([
            'name' => 'key',
            'label' => trans('brandstudio::roles.key'),
            'type' => 'text'
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(RoleRequest::class);

        $this->crud->addFields([
            [
                'name' => 'key',
                'label' => trans('brandstudio::roles.key'),
                'type' => 'text',
                'attributes' => [
                    'required' => true,
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-sm-12 required',
                ],
            ],
            [
                'name' => 'name',
                'label' => trans('brandstudio::roles.name'),
                'type' => 'text',
                'attributes' => [
                    'required' => true,
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-sm-12 required',
                ],
            ],
            [
                'name' => 'permissions',
                'label' => trans_choice('brandstudio::roles.permissions',2),
                'type' => 'checklist',
                'entity'    => 'permissions',
                'attribute' => 'key',
                'model'     => config('permissions.permission_class'),
                'pivot' => true,
            ],
        ]);
        $this->crud->addFields(config('roles.crud_extra_fields'));
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
        $this->crud->removeField('key');
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        $this->setupListOperation();
    }
}
