<?php

return [
    'role_class' => \BrandStudio\Roles\Role::class,

    'use_backpack' => true,
    'crud_middleware' => 'role:admin|developer',

    'allow_create' => true,
    'allow_delete' => true,

    'crud_extra_columns' => [],
    'crud_extra_fields' => [],
];
