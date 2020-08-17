<?php

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin'), config('roles.crud_middleware')],
    'namespace'  => 'BrandStudio\Roles\Http\Controllers',
], function () { // custom admin routes
    Route::crud('role', 'RoleCrudController');
    Route::crud('permission', 'PermissionCrudController');
});
