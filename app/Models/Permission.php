<?php

namespace App\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $guarded = [];

    public static function hasPermission($name)
    {   
        $isRoot = auth()->guard('api')->user()->roles()->first()->name;
        if($isRoot == 'root') {
            $obj = true;
        } else {
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
        }
        return $obj ?? false;
    }

    public static function fetchPermissionGroups()
    {
        $obj = [];
        // only tables allow in permissions
        $tables = self::tableHasPermissions();
        $permissions = self::get();
        for($i=0; $i < count($tables); $i++) {
          foreach ($permissions as $permission) {
            if(strpos($permission->name, $tables[$i]) !== false) {
                $obj[$tables[$i]][] = [
                      'id'     => $permission->id, 
                      'name'   => explode('_', $permission->name)[0],
                      'parent' => ucfirst($tables[$i])
                ];
            }
          }
        }
        return $obj;
    }

    public static function fetchPermissionGroupsByTenant()
    {
        $obj = [];
        // only tables allow in permissions
        $tables = self::tableHasPermissions();
        $permissions = self::get();
        for($i=0; $i < count($tables); $i++) {
          foreach ($permissions as $permission) {
            if(strpos($permission->name, $tables[$i]) !== false) {
                $obj[$tables[$i]][] = [
                      'id'     => $permission->id, 
                      'name'   => explode('_', $permission->name)[0],
                      'parent' => ucfirst($tables[$i])
                ];
            }
          }
        }
        return $obj;
    }


    public static function tableHasPermissions()
    {
        $migrations = DB::table('migrations')->get();
        foreach ($migrations as $migrate) {
            // skip field_jobs table & some tables....
            if(strpos($migrate->migration, 'failed_jobs_table') !== false) {}
            else if(strpos($migrate->migration, 'password_resets') !== false) {}
            else if(strpos($migrate->migration, 'permissions') !== false) {}
            else if(strpos($migrate->migration, 'metables') !== false) {}
            else if(strpos($migrate->migration, 'imageables') !== false) {}
            else if(strpos($migrate->migration, 'visitors') !== false) {}
                // feel free to add any restirected tables...
                
            else {
                // extract create_ and _table from migrations
                $tables[] = explode('_table',explode('create_',$migrate->migration)[1])[0];
            }
        }
        return $tables ?? [];
    }


    public static function permissionType($i='')
    {
        if($i == 0) { 
            $instance = 'view';
        } else if ($i == 1) {
            $instance = 'add';
        } else if ($i == 2) {
            $instance = 'edit';
        } else {
            $instance = 'delete';
        }

        return $instance;
    }


    public static function getPermissionsIds($role_id)
    {
       $rows = DB::table('role_has_permissions')->where('role_id', $role_id)->get();
       foreach ($rows as $row) {
          $array[] = $row->permission_id;
       }
       return $array ?? [];
    }


}
