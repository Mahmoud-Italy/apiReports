<?php

namespace App\Models;

use DB;
use App\Models\Imageable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];

    public function image() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', false)->select('url');
    }

    public function image2() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', true)->select('url');
    }

    // fetch Data
    public static function fetchData($value='')
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
              $row            = (isset($id)) ? self::findOrFail($id) : new self;
              $row->bgTitle   = (isset($value['bgTitle'])) ? $value['bgTitle'] : NULL;
              $row->bgSubTitle   = (isset($value['bgSubTitle'])) ? $value['bgSubTitle'] : NULL;
              $row->bgColor   = (isset($value['bgColor'])) ? $value['bgColor'] : NULL;
              $row->body1     = (isset($value['body1']) && $value['body1']) ? $value['body1'] : NULL;
              $row->body2     = (isset($value['body2']) && $value['body2']) ? $value['body2'] : NULL;
              $row->body3     = (isset($value['body3']) && $value['body3']) ? $value['body3'] : NULL;
              $row->body4     = (isset($value['body4']) && $value['body4']) ? $value['body4'] : NULL;
              $row->body5     = (isset($value['body5']) && $value['body5']) ? $value['body5'] : NULL;
              $row->body6     = (isset($value['body6']) && $value['body6']) ? $value['body6'] : NULL;
              $row->save();

              // Image
              if(isset($value['base64Image'])) {
                $row->image()->delete();
                if($value['base64Image']) {
                  if(!Str::contains($value['base64Image'], ['uploads','false'])) {
                    $image = Imageable::uploadImage($value['base64Image']);
                  } else {
                    $image = explode('/', $value['base64Image']);
                    $image = end($image);
                  }
                  $row->image()->create(['url' => $image]);
                }
              }

              if(isset($value['base64Image2'])) {
                $row->image2()->delete();
                if($value['base64Image2']) {
                  if(!Str::contains($value['base64Image2'], ['uploads','false'])) {
                    $image2 = Imageable::uploadImage($value['base64Image2']);
                  } else {
                    $image2 = explode('/', $value['base64Image2']);
                    $image2 = end($image2);
                  }
                  $row->image2()->create(['url' => $image2, 'type' => 1]);
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
