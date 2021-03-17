<?php

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable,HasRoles;

    protected $fillable = [
        'name', 'email', 'password',
    ];

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
