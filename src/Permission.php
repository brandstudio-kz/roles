<?php

namespace BrandStudio\Roles;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Permission extends Model
{
    use CrudTrait;

    protected $table = 'permissions';
    protected $guarded = ['id'];


    public function roles()
    {
        return $this->morphedByMany(Role::class, 'permissionable');
    }

    public static function getNamesByModelAndAction(string $model, string $action) : string
    {
        $model = trim($model);
        $action = trim($action);

        $names = self::select('key')->where('model', $model)->where('name', $action)->get()->pluck('key')->toArray();
        switch(count($names)) {
            case 0:
                abort(404, 'permission does not exist');
            case 1:
                return $names[0];
            default:
                abort(408, 'duplicate permission');
        }
    }

    public static function getNamesByModelAndActions(string $model, $actions) : array
    {
        $names = [];
        $actions = is_string($actions) ? explode(',', $actions) : $actions;

        foreach($actions as $action) {
            $names[] = self::getNamesByModelAndAction($model, $action);
        }
        return $names;
    }
}
