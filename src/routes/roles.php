<?php

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'BrandStudio\Roles\Http\Controllers',
], function () { // custom admin routes
    Route::crud('role', 'RoleCrudController');
});
