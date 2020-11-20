<?php

namespace App\Models;

use DB;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }


     // fetch Data
    public static function fetchData($value)
    {
        // this way will fire up speed of the query
        $obj = self::query();

          // search for multiple columns..
          if(isset($value['search']) && $value['search']) {
            $obj->where(function($q) use ($value) {
                $q->where('provider', 'like', '%'.$value['search'].'%');
                $q->orWhere('id', $value['search']);
              });
          }

          if(isset($value['filter']) && $value['filter']) {
            if($value['filter_by'] == 'author') {
              $obj->where('user_id', decrypt($value['filter']));
            }
          }

          // status
          if(isset($value['status']) && $value['status']) {
              if($value['status'] == 'active')
                  $obj->where(['status' => true, 'trash' => false]);
              else if ($value['status'] == 'inactive')
                  $obj->where(['status' => false, 'trash' => false]);
              else if ($value['status'] == 'trash')
                  $obj->where('trash', true);
          }

          // order By..
          if(isset($value['order']) && $value['order']) {
            if($value['order_by'] == 'provider')
              $obj->orderBy('provider', $value['order']);
            else if ($value['order_by'] == 'created_at')
              $obj->orderBy('created_at', $value['order']);
            else
              $obj->orderBy('id', $value['order']);
          } else {
            $obj->orderBy('id', 'DESC');
          }

          // feel free to add any query filter as much as you want...

        $obj = $obj->paginate($value['paginate'] ?? 10);
        return $obj;
    }



    // 
    public static function createOrUpdate($id, $value)
    {
        try {
            
            DB::beginTransaction();

              // Row
              $row               = (isset($id)) ? self::findOrFail($id) : new self;
              $row->user_id      = auth()->guard('api')->user()->id;
              $row->provider     = strtolower($value['provider']) ?? NULL;
              $row->provider_url = $value['provider_url'] ?? NULL;
              $row->status       = (boolean)$value['status'] ?? false;
              $row->save();

              //


            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
