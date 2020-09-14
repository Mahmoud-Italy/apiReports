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

              $row->mabody1         = $value['mabody1'] ?? NULL;
              $row->mabody2         = $value['mabody2'] ?? NULL;
              $row->mabody3         = $value['mabody3'] ?? NULL;
              $row->mabody4         = $value['mabody4'] ?? NULL;

              $row->iabody1         = $value['iabody1'] ?? NULL;
              $row->iabody2         = $value['iabody2'] ?? NULL;
              $row->iabody3         = $value['iabody3'] ?? NULL;
              $row->iabody4         = $value['iabody4'] ?? NULL;

              $row->pabody1         = $value['pabody1'] ?? NULL;
              $row->pabody2         = $value['pabody2'] ?? NULL;
              $row->pabody3         = $value['pabody3'] ?? NULL;
              $row->pabody4         = $value['pabody4'] ?? NULL;

              $row->habody1         = $value['habody1'] ?? NULL;
              $row->habody2         = $value['habody2'] ?? NULL;
              $row->habody3         = $value['habody3'] ?? NULL;
              $row->habody4         = $value['habody4'] ?? NULL;

              $row->cabody1         = $value['cabody1'] ?? NULL;
              $row->cabody2         = $value['cabody2'] ?? NULL;
              $row->cabody3         = $value['cabody3'] ?? NULL;
              $row->cabody4         = $value['cabody4'] ?? NULL;

              $row->aabody1         = $value['aabody1'] ?? NULL;
              $row->aabody2         = $value['aabody2'] ?? NULL;
              $row->aabody3         = $value['aabody3'] ?? NULL;
              $row->aabody4         = $value['aabody4'] ?? NULL;


              $row->save();

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }
}
