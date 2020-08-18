<?php

namespace App\Models;

use DB;
use App\Models\Imageable;
use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    protected $guarded = [];

    public function image() {
        return $this->morphOne(Imageable::class, 'imageable')->select('url');
    }


    // fetch Data
    public static function fetchData($value='')
    {
        // this way will fire up speed of the query
        $obj = self::query();

          // get only his tenants
          $obj->has('tenant');

          // search for multiple columns..
          if(isset($value['search']) && $value['search']) {
            $obj->where(function($q) use ($value) {
                $q->where('slug', 'like', '%'.$value['search'].'%');
                $q->orWhere('title', 'like', '%'.$value['search'].'%');
                $q->orWhere('id', $value['search']);
              });
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
            if($value['order_by'] == 'title')
              $obj->orderBy('title', $value['order']);
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
              $row              = (isset($id)) ? self::findOrFail($id) : new self;
              $row->slug        = $value['slug'] ?? NULL;
              $row->title       = $value['title'] ?? NULL;
              $row->body        = $value['body'] ?? NULL;
              $row->status      = $value['status'] ?? false;
              $row->save();

              // Image
              if(isset($value['image'])) {
                if($value['image']) {
                    $image = Imageable::uploadImage($value['image'], 'faq');
                    $row->image()->delete();
                    $row->image()->create(['url' => $image]);
                }
              }


            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

}
