<?php

namespace App\Models;

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
              $row->body1         = $value['body1'] ?? NULL;
              $row->body2         = $value['body2'] ?? NULL;
              $row->body3         = $value['body3'] ?? NULL;
              $row->body4         = $value['body4'] ?? NULL;
              $row->save();

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }
}
