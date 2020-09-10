<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $guarded = [];

    // createOrUpdate
    public static function createOrUpdate($id, $value)
    {
        try {
            
            DB::beginTransaction();

              // Row
              $row                = (isset($id)) ? self::findOrFail($id) : new self;
              $row->fbody1         = $value['fbody1'] ?? NULL;
              $row->fbody2         = $value['fbody2'] ?? NULL;
              $row->fbody3         = $value['fbody3'] ?? NULL;
              $row->fbody4         = $value['fbody4'] ?? NULL;

              $row->rbody1         = $value['rbody1'] ?? NULL;
              $row->rbody2         = $value['rbody2'] ?? NULL;
              $row->rbody3         = $value['rbody3'] ?? NULL;
              $row->rbody4         = $value['rbody4'] ?? NULL;

              $row->vbody1         = $value['vbody1'] ?? NULL;
              $row->vbody2         = $value['vbody2'] ?? NULL;
              $row->vbody3         = $value['vbody3'] ?? NULL;
              $row->vbody4         = $value['vbody4'] ?? NULL;

              $row->wbody1         = $value['wbody1'] ?? NULL;
              $row->wbody2         = $value['wbody2'] ?? NULL;
              $row->wbody3         = $value['wbody3'] ?? NULL;
              $row->wbody4         = $value['wbody4'] ?? NULL;
              $row->save();

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }
}
