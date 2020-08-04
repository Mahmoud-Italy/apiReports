<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $guarded = [];


    public static function getCurrentTenant()
    {
        return request()->root();
    }
    public static function getTenantId()
    {
        $obj = NULL;
        $row = self::where('domain', request()->root())->first();
        if($row) {
          $obj = $row->tenant_id;
        }

        return $obj;
    }
}
