<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{

    public function run()
    {
        $crud = ['create', 'update', 'view', 'delete'];
        $models = config('permissions.permission_models');
        $class = config('permissions.permission_class');

        foreach($models as $model) {
            foreach($crud as $action) {
                $class::firstOrCreate([
                    'name' => "{$action}",
                    'key' => "{$action} {$model}",
                    'model' => "{$model}",
                ]);
            }
        }

    }
}
