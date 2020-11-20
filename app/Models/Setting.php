<?php

namespace App\Models;

use DB;
use App\Models\User;
use App\Models\Imageable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function image() {
        return $this->morphOne(Imageable::class, 'imageable')
                    ->select('image_url', 'image_alt', 'image_title');
    }


    // fetch Data
    public static function fetchData($value)
    {
        // this way will fire up speed of the query
        $obj = self::query();

          // search for multiple columns..
          if(isset($value['search']) && $value['search']) {
            $obj->where(function($q) use ($value) {
                $q->where('title', 'like', '%'.$value['search'].'%');
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
            if($value['order_by'] == 'name')
              $obj->orderBy('name', $value['order']);
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
              $row->user_id     = auth()->guard('api')->user()->id;
              $row->title       = $value['title'] ?? NULL;
              $row->body        = $value['body'] ?? NULL;
              $row->save();

              // Image
              if(isset($value['image_base64'])) {
                $row->image()->delete();
                if($value['image_base64']) {
                  if(!Str::contains($value['image_base64'], [ Imageable::contains() ])) {
                    $image = Imageable::uploadImage($value['image_base64'], 'setting');
                  } else {
                    $image = explode('/', $value['image_base64']);
                    $image = end($image);
                  }
                  $row->image()->create([
                      'image_url'       => $image ?? NULL,
                      'image_alt'       => $value['image_alt'] ?? NULL,
                      'image_title'     => $value['image_title'] ?? NULL
                  ]);
                }
              }


            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }


    public static function getRow($value)
    {
      $row = self::query();

        if(is_numeric($value)) {
           $row->where('id', $value);
        } else {
           $row->where('slug', $value);
        }
      $row = $row->first();  
      return $row ?? NULL;
    }

}
