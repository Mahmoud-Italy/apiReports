<?php

namespace App\Models;

use DB;
use App\Models\Imageable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $guarded = [];

    public function image() {
        return $this->morphOne(Imageable::class, 'imageable')
                  ->where('type', false)
                  ->where('is_pdf', false)
                  ->select('url');
    }

    public function image5_2() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', true)->select('url');
    }
    
    public function image_pdf() {
        return $this->morphOne(Imageable::class, 'imageable')->where('is_pdf', true)->select('url');
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
              $row->bgTitle       = $value['bgTitle'] ?? NULL;
              $row->bgColor       = $value['bgColor'] ?? NULL;

              $row->title2_1      = $value['title2_1'] ?? NULL;
              $row->title2_2      = $value['title2_2'] ?? NULL;
              $row->body2_1       = $value['body2_1'] ?? NULL;
              $row->video2_2      = $value['video2_2'] ?? NULL;

              $row->title3_1      = $value['title3_1'] ?? NULL;
              $row->title3_2      = $value['title3_2'] ?? NULL;
              $row->body3_1       = $value['body3_1'] ?? NULL;
              $row->body3_2      = $value['body3_2'] ?? NULL;

              $row->title4_1      = $value['title4_1'] ?? NULL;
              $row->title4_2      = $value['title4_2'] ?? NULL;
              $row->body4_1       = $value['body4_1'] ?? NULL;
              $row->body4_2      = $value['body4_2'] ?? NULL;

              $row->title5_1      = $value['title5_1'] ?? NULL;
              $row->title5_2      = $value['title3_2'] ?? NULL;
              $row->body5_1       = $value['body5_1'] ?? NULL;
              $row->body5_3       = $value['body5_3'] ?? NULL;
              $row->body5_4      = $value['body5_4'] ?? NULL;

              
              $row->has_download  = (isset($value['has_download']) && $value['has_download']) 
                                      ? (boolean)$value['has_download'] 
                                      : false;
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

              if(isset($value['pdf_file'])) {
                $row->image_pdf()->delete();
                if($value['pdf_file']) {
                  if(!Str::contains($value['pdf_file'], ['uploads','false'])) {
                    $pdf_file = Imageable::uploadImage($value['pdf_file']);
                  } else {
                    $pdf_file = explode('/', $value['pdf_file']);
                    $pdf_file = end($pdf_file);
                  }
                  $row->image_pdf()->create(['url' => $pdf_file, 'is_pdf' => true]);
                }
              }


              if(isset($value['image5_2'])) {
                $row->image5_2()->delete();
                if($value['image5_2']) {
                  if(!Str::contains($value['image5_2'], ['uploads','false'])) {
                    $image5_2 = Imageable::uploadImage($value['image5_2']);
                  } else {
                    $image5_2 = explode('/', $value['image5_2']);
                    $image5_2 = end($image5_2);
                  }
                  $row->image5_2()->create(['url' => $image5_2, 'type' => true]);
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
