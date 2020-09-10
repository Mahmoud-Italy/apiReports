<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $guarded = [];

    public static function hasPermission($name)
    {
        $obj = false;
        $row = self::where('name', $name)->first();
        if($row && auth()->guard('api')->user()) {
          $role = DB::table('role_has_permissions')
                    ->where('permission_id', $row->id)
                    ->where('role_id', auth()->guard('api')->user()->roles()->first()->id)
                    ->first();
            if($role) {
              $obj = true;
            }
        }
        return $obj;
    }
}
