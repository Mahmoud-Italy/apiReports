<?php

namespace App\Models;

use DB;
use Str;
use App\Models\Product;
use App\Models\Imageable;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $guarded = [];

    public function image() {
        return $this->morphOne(Imageable::class, 'imageable')->select('url');
    }

    public function programs() {
        return $this->hasMany(Product::class, 'sector_id'); 
    }

    public function childs() {
        return $this->hasMany(__NAMESPACE__.'\\'.class_basename(new self), 'parent_id'); 
    }

    public function parent()
    {
        return $this->belongsTo(__NAMESPACE__.'\\'.class_basename(new self),'parent_id')->select('title');
    }

    // fetch Data
    public static function fetchData($value='')
    {
        // this way will fire up speed of the query
        $obj = self::query();

          if(isset($value['program_id']) && $value['program_id']) {
            $obj->where('program_id', decrypt($value['program_id']));
          }

          // search for multiple columns..
          if(isset($value['search']) && $value['search']) {
            $obj->where(function($q) use ($value) {
                $q->where('slug', 'like', '%'.$value['search'].'%');
                $q->orWhere('title', 'like', '%'.$value['search'].'%');
                $q->orWhere('id', $value['search']);
              });
          }

          if(isset($value['parent_id'])) {
            if($value['parent_id'] == 1) {
               $obj->whereNULL('parent_id');
            } else if($value['parent_id'] != 1) {
                $obj->whereNOTNULL('parent_id');
            } else {
                $obj->whereNULL('parent_id');
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
            if($value['order_by'] == 'title')
              $obj->orderBy('title', $value['order']);
            else if ($value['order_by'] == 'created_at')
              $obj->orderBy('created_at', $value['order']);
            else
              $obj->orderBy('id', $value['order']);
          } else {
            $obj->orderBy('sort', 'DESC');
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
              $row                 = (isset($id)) ? self::findOrFail($id) : new self;
              // $row->parent_id      = (isset($value['parent_id']) && $value['parent_id'] != 1)
              //                           ? decrypt($value['parent_id'])
              //                           : NULL;
              $row->parent_id      = NULL;
              $row->program_id     = (isset($value['program_id']) && $value['program_id']) 
                                      ? decrypt($value['program_id']) 
                                      : NULL;
              $row->slug           = strtolower($value['slug']) ?? NULL;
              $row->title          = $value['title'] ?? NULL;
              $row->body           = $value['body'] ?? NULL;
              $row->sort           = (int)$value['sort'] ?? 0;
              $row->status         = (boolean)$value['status'] ?? false;
              $row->save();


              if(isset($value['base64Image'])) {
                if($value['base64Image']) {
                  $image = Imageable::uploadImage($value['base64Image']);
                  $row->image()->delete();
                  $row->image()->create(['url' => $image]);
                }
              }


            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

}
