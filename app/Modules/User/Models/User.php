<?php

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    public static function getPermissionByGroup($id)
    {
        return DB::table('permissions')->where('group','=',$id)->get();
    }

    public static function roleHasPermission($role,$permissions)
    {
        $hasPermission = true;
        foreach ($permissions as $permission)
        {
            if(!$role->hasPermissionTo($permission->name))
            {
                $hasPermission = false;
                return $hasPermission;
            }
        }
        return $hasPermission;
    }
}
