<?php

namespace App\Models;

use DB;
use App\Models\Sector;
use App\Models\Imageable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $guarded = [];

    public function image() {
        return $this->morphOne(Imageable::class, 'imageable')
                  ->where('type', 0)
                  ->where('is_pdf', 0)
                  ->select('url');
    }
    public function image_pdf() {
        return $this->morphOne(Imageable::class, 'imageable')->where('is_pdf', 2)->select('url');
    }
    public function pdf() {
        return $this->morphOne(Imageable::class, 'imageable')->where('is_pdf', 1)->select('url');
    }

    public function sectors() {
        return $this->hasMany(Sector::class, 'program_id')
                    ->whereNULL('parent_id')
                    ->where(['status' => true, 'trash' => false])
                    ->orderBY('sort','DESC');
    }


    // fetchData
    public static function fetchData($value='')
    {
        // this way will fire up speed of the query
        $obj = self::query();

          
          // search for multiple columns..
          if(isset($value['search']) && $value['search']) {
            $obj->where(function($q) use ($value) {
                $q->where('title', 'like', '%'.$value['search'].'%');
                $q->orWhere('body', 'like', '%'.$value['search'].'%');
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
            $obj->orderBy('sort', 'DESC');
          }

          // feel free to add any query filter as much as you want...

        $obj = $obj->paginate($value['paginate'] ?? 10);
        return $obj;
    }



    // createOrUpdate
    public static function createOrUpdate($id, $value)
    {
        try {
            
            DB::beginTransaction();

              // Row
              $row                = (isset($id)) ? self::findOrFail($id) : new self;
              $row->slug          = strtolower($value['slug']) ?? NULL;
              $row->title         = $value['title'] ?? NULL;
              $row->body          = $value['body'] ?? NULL;
              $row->bgTitle       = $value['bgTitle'] ?? NULL;
              $row->bgColor       = $value['bgColor'] ?? NULL;

              $row->imgDir        = $value['imgDir'] ?? NULL;
              $row->link          = $value['link'] ?? NULL;
              
              $row->download_name = $value['download_name'] ?? NULL;

              $row->sort          = (int)$value['sort'] ?? 0;
              $row->has_sectors   = (boolean)$value['has_sectors'] ?? false;

              $row->has_application  = (isset($value['has_application']) && $value['has_application'])
                                        ? (boolean)$value['has_application'] : false;
              $row->application_name = (isset($value['application_name']) && $value['application_name']) 
                                        ? $value['application_name'] : NULL;
              $row->application_path = (isset($value['application_path']) && $value['application_path']) 
                                        ? $value['application_path'] : NULL;

              $row->status        = (boolean)$value['status'] ?? false;
              $row->save();

              // Image
              if(isset($value['image'])) {
                $row->image()->delete();
                if($value['image']) {
                  if(!Str::contains($value['image'], ['uploads','false'])) {
                    $image = Imageable::uploadImage($value['image']);
                  } else {
                    $image = explode('/', $value['image']);
                    $image = end($image);
                  }
                  $row->image()->create(['url' => $image]);
                }
              }


              if(isset($value['download_file'])) {
                $row->pdf()->delete();
                if($value['download_file']) {
                  if(!Str::contains($value['download_file'], ['uploads','false'])) {
                    $pdf = Imageable::uploadImage($value['download_file']);
                  } else {
                    $pdf = explode('/', $value['download_file']);
                    $pdf = end($pdf);
                  }
                  $row->pdf()->create(['url' => $pdf, 'is_pdf' => 1]);
                }
              }
              if(isset($value['download_image'])) {
                $row->image_pdf()->delete();
                if($value['download_image']) {
                  if(!Str::contains($value['download_image'], ['uploads','false'])) {
                    $image_pdf = Imageable::uploadImage($value['download_image']);
                  } else {
                    $image_pdf = explode('/', $value['download_image']);
                    $image_pdf = end($image_pdf);
                  }
                  $row->image_pdf()->create(['url' => $image_pdf, 'is_pdf' => 2]);
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
