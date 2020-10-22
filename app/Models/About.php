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

    public function image5_1() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 1)->select('url');
    }
    public function image5_2() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 2)->select('url');
    }
    public function image5_3() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 3)->select('url');
    }
    public function image5_4() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 4)->select('url');
    }
    public function image5_5() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 5)->select('url');
    }
    public function image5_6() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 6)->select('url');
    }
    public function image5_7() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 7)->select('url');
    }
    public function image5_8() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 8)->select('url');
    }
    
    public function image_pdf() {
        return $this->morphOne(Imageable::class, 'imageable')->where('is_pdf', 2)->select('url');
    }
    public function pdf() {
        return $this->morphOne(Imageable::class, 'imageable')->where('is_pdf', 1)->select('url');
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
              
              $row->bgTitle       = $value['bgTitle'] ?? NULL;
              $row->bgColor       = $value['bgColor'] ?? NULL;
              $row->body1         = $value['body1'] ?? NULL;

              $row->title2_1      = $value['title2_1'] ?? NULL;
              $row->title2_2      = $value['title2_2'] ?? NULL;
              $row->body2_1       = $value['body2_1'] ?? NULL;
              $row->video2_2      = $value['video2_2'] ?? NULL;

              $row->title3_1      = $value['title3_1'] ?? NULL;
              $row->title3_2      = $value['title3_2'] ?? NULL;
              $row->body3_1       = $value['body3_1'] ?? NULL;
              $row->body3_2       = $value['body3_2'] ?? NULL;

              $row->title4_1      = $value['title4_1'] ?? NULL;
              $row->title4_2      = $value['title4_2'] ?? NULL;
              $row->body4_1       = $value['body4_1'] ?? NULL;
              $row->body4_2       = $value['body4_2'] ?? NULL;

              $row->title5_1      = $value['title5_1'] ?? NULL;
              $row->title5_2      = $value['title3_2'] ?? NULL;

              $row->body5_1       = $value['body5_1'] ?? NULL;
              $row->read5_1       = $value['read5_1'] ?? NULL;
              $row->body5_2       = $value['body5_2'] ?? NULL;
              $row->read5_2       = $value['read5_2'] ?? NULL;
              $row->body5_3       = $value['body5_3'] ?? NULL;
              $row->read5_3       = $value['read5_3'] ?? NULL;
              $row->body5_4       = $value['body5_4'] ?? NULL;
              $row->read5_4       = $value['read5_4'] ?? NULL;
              $row->body5_5       = $value['body5_5'] ?? NULL;
              $row->read5_5       = $value['read5_5'] ?? NULL;
              $row->body5_6       = $value['body5_6'] ?? NULL;
              $row->read5_6       = $value['read5_6'] ?? NULL;
              $row->body5_7       = $value['body5_7'] ?? NULL;
              $row->read5_7       = $value['read5_7'] ?? NULL;
              $row->body5_8       = $value['body5_8'] ?? NULL;
              $row->read5_8       = $value['read5_8'] ?? NULL;

              $row->has_faq         = (isset($value['has_faq']) && $value['has_faq']) 
                                        ? (boolean)$value['has_faq'] : false;
              $row->faq_link       = (isset($value['faq_link']) && $value['faq_link']) 
                                        ? $value['faq_link'] : NULL;


              $row->has_application  = (isset($value['has_application']) && $value['has_application'])
                                        ? (boolean)$value['has_application'] : false;
              $row->application_name = (isset($value['application_name']) && $value['application_name']) 
                                        ? $value['application_name'] : NULL;
              $row->application_path = (isset($value['application_path']) && $value['application_path']) 
                                        ? $value['application_path'] : NULL;
                                        
                                        
              $row->has_download    = (isset($value['has_download']) && $value['has_download']) 
                                        ? (boolean)$value['has_download']  : false;
              $row->download_name   = $value['download_name'] ?? NULL;


              $row->has_payment     = (isset($value['has_payment']) && $value['has_payment'])
                                        ? (boolean)$value['has_payment'] : false;
              $row->payment_name    = (isset($value['payment_name']) && $value['payment_name']) 
                                        ? $value['payment_name'] : NULL;
              $row->payment_link    = (isset($value['payment_link']) && $value['payment_link']) 
                                        ? $value['payment_link'] : NULL;
                                   

              $row->sort            = (int)$value['sort'] ?? 0;
              $row->status          = (isset($value['status']) && $value['status']) 
                                        ? (boolean)$value['status'] 
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



              if(isset($value['image5_1'])) {
                $row->image5_1()->delete();
                if($value['image5_1']) {
                  if(!Str::contains($value['image5_1'], ['uploads','false'])) {
                    $image5_1 = Imageable::uploadImage($value['image5_1']);
                  } else {
                    $image5_1 = explode('/', $value['image5_1']);
                    $image5_1 = end($image5_1);
                  }
                  $row->image5_1()->create(['url' => $image5_1, 'type' => 1]);
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
                  $row->image5_2()->create(['url' => $image5_2, 'type' => 2]);
                }
              }
              if(isset($value['image5_3'])) {
                $row->image5_3()->delete();
                if($value['image5_3']) {
                  if(!Str::contains($value['image5_3'], ['uploads','false'])) {
                    $image5_3 = Imageable::uploadImage($value['image5_3']);
                  } else {
                    $image5_3 = explode('/', $value['image5_3']);
                    $image5_3 = end($image5_3);
                  }
                  $row->image5_3()->create(['url' => $image5_3, 'type' => 3]);
                }
              }
              if(isset($value['image5_4'])) {
                $row->image5_4()->delete();
                if($value['image5_4']) {
                  if(!Str::contains($value['image5_4'], ['uploads','false'])) {
                    $image5_4 = Imageable::uploadImage($value['image5_4']);
                  } else {
                    $image5_4 = explode('/', $value['image5_4']);
                    $image5_4 = end($image5_4);
                  }
                  $row->image5_4()->create(['url' => $image5_4, 'type' => 4]);
                }
              }
              if(isset($value['image5_5'])) {
                $row->image5_5()->delete();
                if($value['image5_5']) {
                  if(!Str::contains($value['image5_5'], ['uploads','false'])) {
                    $image5_5 = Imageable::uploadImage($value['image5_5']);
                  } else {
                    $image5_5 = explode('/', $value['image5_5']);
                    $image5_5 = end($image5_5);
                  }
                  $row->image5_5()->create(['url' => $image5_5, 'type' => 5]);
                }
              }
              if(isset($value['image5_6'])) {
                $row->image5_6()->delete();
                if($value['image5_6']) {
                  if(!Str::contains($value['image5_6'], ['uploads','false'])) {
                    $image5_6 = Imageable::uploadImage($value['image5_6']);
                  } else {
                    $image5_6 = explode('/', $value['image5_6']);
                    $image5_6 = end($image5_6);
                  }
                  $row->image5_6()->create(['url' => $image5_6, 'type' => 6]);
                }
              }
              if(isset($value['image5_7'])) {
                $row->image5_7()->delete();
                if($value['image5_7']) {
                  if(!Str::contains($value['image5_7'], ['uploads','false'])) {
                    $image5_7 = Imageable::uploadImage($value['image5_7']);
                  } else {
                    $image5_7 = explode('/', $value['image5_7']);
                    $image5_7 = end($image5_7);
                  }
                  $row->image5_7()->create(['url' => $image5_7, 'type' => 7]);
                }
              }
              if(isset($value['image5_8'])) {
                $row->image5_8()->delete();
                if($value['image5_8']) {
                  if(!Str::contains($value['image5_8'], ['uploads','false'])) {
                    $image5_8 = Imageable::uploadImage($value['image5_8']);
                  } else {
                    $image5_8 = explode('/', $value['image5_8']);
                    $image5_8 = end($image5_8);
                  }
                  $row->image5_8()->create(['url' => $image5_8, 'type' => 8]);
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
