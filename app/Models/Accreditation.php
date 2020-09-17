<?php

namespace App\Models;

use DB;
use App\Models\Imageable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Accreditation extends Model
{
    protected $guarded = [];

    public function image() {
        return $this->morphOne(Imageable::class, 'imageable')
                  ->where('type', 0)
                  ->where('is_pdf', 0)
                  ->select('url');
    }

    public function image2_6() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 1)->select('url');
    }
    public function image2_7() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 2)->select('url');
    }
    public function image2_8() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 3)->select('url');
    }
    public function image2_9() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 4)->select('url');
    }
    public function image2_10() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 5)->select('url');
    }
    public function image2_11() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 6)->select('url');
    }
    public function image2_12() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 7)->select('url');
    }
    public function image2_13() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 8)->select('url');
    }


    public function image3_2() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 9)->select('url');
    }
    public function image3_3() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 10)->select('url');
    }
    public function image3_4() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 11)->select('url');
    }
    public function image3_5() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 12)->select('url');
    }
    public function image3_6() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 13)->select('url');
    }
    public function image3_7() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 14)->select('url');
    }
    public function image3_8() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 15)->select('url');
    }
    public function image3_9() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 16)->select('url');
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

              // d1
              $row->body1_1       = $value['body1_1'] ?? NULL;
              
              // d2
              $row->body2_1       = $value['body2_1'] ?? NULL;
              $row->body2_2       = $value['body2_2'] ?? NULL;
              $row->body2_3       = $value['body2_3'] ?? NULL;
              $row->body2_4       = $value['body2_4'] ?? NULL;
              $row->body2_5       = $value['body2_5'] ?? NULL;
              $row->body2_6       = $value['body2_6'] ?? NULL;
              $row->body2_7       = $value['body2_7'] ?? NULL;
              $row->body2_8       = $value['body2_8'] ?? NULL;
              $row->body2_9       = $value['body2_9'] ?? NULL;
              $row->body2_10      = $value['body2_10'] ?? NULL;
              $row->body2_11      = $value['body2_11'] ?? NULL;
              $row->body2_12      = $value['body2_12'] ?? NULL;
              $row->body2_13      = $value['body2_13'] ?? NULL;

              // d3
              $row->body3_1       = $value['body3_1'] ?? NULL;
              
              $row->line3_2       = $value['line3_2'] ?? NULL;
              $row->mask3_2       = $value['mask3_2'] ?? NULL;
              $row->color3_2      = $value['color3_2'] ?? NULL;
              $row->body3_2_1     = $value['body3_2_1'] ?? NULL;
              $row->body3_2_2     = $value['body3_2_2'] ?? NULL;

              $row->line3_3       = $value['line3_3'] ?? NULL;
              $row->mask3_3       = $value['mask3_3'] ?? NULL;
              $row->color3_3      = $value['color3_3'] ?? NULL;
              $row->body3_3_1     = $value['body3_3_1'] ?? NULL;
              $row->body3_3_2     = $value['body3_3_2'] ?? NULL;

              $row->line3_4       = $value['line3_4'] ?? NULL;
              $row->mask3_4       = $value['mask3_4'] ?? NULL;
              $row->color3_4      = $value['color3_4'] ?? NULL;
              $row->body3_4_1     = $value['body3_4_1'] ?? NULL;
              $row->body3_4_2     = $value['body3_4_2'] ?? NULL;

              $row->line3_5       = $value['line3_5'] ?? NULL;
              $row->mask3_5       = $value['mask3_5'] ?? NULL;
              $row->color3_5      = $value['color3_5'] ?? NULL;
              $row->body3_5_1     = $value['body3_5_1'] ?? NULL;
              $row->body3_5_2     = $value['body3_5_2'] ?? NULL;

              $row->line3_6       = $value['line3_6'] ?? NULL;
              $row->mask3_6       = $value['mask3_6'] ?? NULL;
              $row->color3_6      = $value['color3_6'] ?? NULL;
              $row->body3_6_1     = $value['body3_6_1'] ?? NULL;
              $row->body3_6_2     = $value['body3_6_2'] ?? NULL;

              $row->line3_7       = $value['line3_7'] ?? NULL;
              $row->mask3_7       = $value['mask3_7'] ?? NULL;
              $row->color3_7      = $value['color3_7'] ?? NULL;
              $row->body3_7_1     = $value['body3_7_1'] ?? NULL;
              $row->body3_7_2     = $value['body3_7_2'] ?? NULL;

              $row->line3_8       = $value['line3_8'] ?? NULL;
              $row->mask3_8       = $value['mask3_8'] ?? NULL;
              $row->color3_8      = $value['color3_8'] ?? NULL;
              $row->body3_8_1     = $value['body3_8_1'] ?? NULL;
              $row->body3_8_2     = $value['body3_8_2'] ?? NULL;

              $row->line3_9       = $value['line3_9'] ?? NULL;
              $row->mask3_9       = $value['mask3_9'] ?? NULL;
              $row->color3_9      = $value['color3_9'] ?? NULL;
              $row->body3_9_1     = $value['body3_9_1'] ?? NULL;
              $row->body3_9_2     = $value['body3_9_2'] ?? NULL;

              // d4
              $row->body4_0      = $value['body4_0'] ?? NULL;
              $row->body4_1      = $value['body4_1'] ?? NULL;
              $row->body4_2      = $value['body4_2'] ?? NULL;
              $row->body4_3      = $value['body4_3'] ?? NULL;
              $row->body4_4      = $value['body4_4'] ?? NULL;
              $row->body4_5      = $value['body4_5'] ?? NULL;
              $row->body4_6      = $value['body4_6'] ?? NULL;
              $row->body4_7      = $value['body4_7'] ?? NULL;
              $row->body4_8      = $value['body4_8'] ?? NULL;
              $row->body4_9      = $value['body4_9'] ?? NULL;
              $row->body4_10     = $value['body4_10'] ?? NULL;


              $row->download_name = $value['download_name'] ?? NULL;
              $row->sort          = (int)$value['sort'] ?? 0;

              $row->has_faq         = (isset($value['has_faq']) && $value['has_faq']) 
                                        ? (boolean)$value['has_faq'] 
                                        : false;
              $row->has_application  = (isset($value['has_application']) && $value['has_application'])
                                        ? (boolean)$value['has_application'] : false;
              $row->application_name = (isset($value['application_name']) && $value['application_name']) 
                                        ? $value['application_name'] : NULL;
              $row->application_path = (isset($value['application_path']) && $value['application_path']) 
                                        ? $value['application_path'] : NULL;
                                        
              $row->has_download    = (isset($value['has_download']) && $value['has_download']) 
                                        ? (boolean)$value['has_download'] 
                                        : false;
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


              if(isset($value['image2_6'])) {
                $row->image2_6()->delete();
                if($value['image2_6']) {
                  if(!Str::contains($value['image2_6'], ['uploads','false'])) {
                    $image2_6 = Imageable::uploadImage($value['image2_6']);
                  } else {
                    $image2_6 = explode('/', $value['image2_6']);
                    $image2_6 = end($image2_6);
                  }
                  $row->image2_6()->create(['url' => $image2_6, 'type' => 1]);
                }
              }

              if(isset($value['image2_7'])) {
                $row->image2_7()->delete();
                if($value['image2_7']) {
                  if(!Str::contains($value['image2_7'], ['uploads','false'])) {
                    $image2_7 = Imageable::uploadImage($value['image2_7']);
                  } else {
                    $image2_7 = explode('/', $value['image2_7']);
                    $image2_7 = end($image2_7);
                  }
                  $row->image2_7()->create(['url' => $image2_7, 'type' => 2]);
                }
              }

              if(isset($value['image2_8'])) {
                $row->image2_8()->delete();
                if($value['image2_8']) {
                  if(!Str::contains($value['image2_8'], ['uploads','false'])) {
                    $image2_8 = Imageable::uploadImage($value['image2_8']);
                  } else {
                    $image2_8 = explode('/', $value['image2_8']);
                    $image2_8 = end($image2_8);
                  }
                  $row->image2_8()->create(['url' => $image2_8, 'type' => 3]);
                }
              }
              if(isset($value['image2_9'])) {
                $row->image2_9()->delete();
                if($value['image2_9']) {
                  if(!Str::contains($value['image2_9'], ['uploads','false'])) {
                    $image2_9 = Imageable::uploadImage($value['image2_9']);
                  } else {
                    $image2_9 = explode('/', $value['image2_9']);
                    $image2_9 = end($image2_9);
                  }
                  $row->image2_9()->create(['url' => $image2_9, 'type' => 4]);
                }
              }
              if(isset($value['image2_10'])) {
                $row->image2_10()->delete();
                if($value['image2_10']) {
                  if(!Str::contains($value['image2_10'], ['uploads','false'])) {
                    $image2_10 = Imageable::uploadImage($value['image2_10']);
                  } else {
                    $image2_10 = explode('/', $value['image2_10']);
                    $image2_10 = end($image2_10);
                  }
                  $row->image2_10()->create(['url' => $image2_10, 'type' => 5]);
                }
              }
              if(isset($value['image2_11'])) {
                $row->image2_11()->delete();
                if($value['image2_11']) {
                  if(!Str::contains($value['image2_11'], ['uploads','false'])) {
                    $image2_11 = Imageable::uploadImage($value['image2_11']);
                  } else {
                    $image2_11 = explode('/', $value['image2_11']);
                    $image2_11 = end($image2_11);
                  }
                  $row->image2_11()->create(['url' => $image2_11, 'type' => 6]);
                }
              }
              if(isset($value['image2_12'])) {
                $row->image2_12()->delete();
                if($value['image2_12']) {
                  if(!Str::contains($value['image2_12'], ['uploads','false'])) {
                    $image2_12 = Imageable::uploadImage($value['image2_12']);
                  } else {
                    $image2_12 = explode('/', $value['image2_12']);
                    $image2_12 = end($image2_12);
                  }
                  $row->image2_12()->create(['url' => $image2_12, 'type' => 7]);
                }
              }
              if(isset($value['image2_13'])) {
                $row->image2_13()->delete();
                if($value['image2_13']) {
                  if(!Str::contains($value['image2_13'], ['uploads','false'])) {
                    $image2_13 = Imageable::uploadImage($value['image2_13']);
                  } else {
                    $image2_13 = explode('/', $value['image2_13']);
                    $image2_13 = end($image2_13);
                  }
                  $row->image2_13()->create(['url' => $image2_13, 'type' => 8]);
                }
              }







              if(isset($value['image3_2'])) {
                $row->image3_2()->delete();
                if($value['image3_2']) {
                  if(!Str::contains($value['image3_2'], ['uploads','false'])) {
                    $image3_2 = Imageable::uploadImage($value['image3_2']);
                  } else {
                    $image3_2 = explode('/', $value['image3_2']);
                    $image3_2 = end($image3_2);
                  }
                  $row->image3_2()->create(['url' => $image3_2, 'type' => 9]);
                }
              }
              if(isset($value['image3_3'])) {
                $row->image3_3()->delete();
                if($value['image3_3']) {
                  if(!Str::contains($value['image3_3'], ['uploads','false'])) {
                    $image3_3 = Imageable::uploadImage($value['image3_3']);
                  } else {
                    $image3_3 = explode('/', $value['image3_3']);
                    $image3_3 = end($image3_3);
                  }
                  $row->image3_3()->create(['url' => $image3_3, 'type' => 10]);
                }
              }
              if(isset($value['image3_4'])) {
                $row->image3_4()->delete();
                if($value['image3_4']) {
                  if(!Str::contains($value['image3_4'], ['uploads','false'])) {
                    $image3_4 = Imageable::uploadImage($value['image3_4']);
                  } else {
                    $image3_4 = explode('/', $value['image3_4']);
                    $image3_4 = end($image3_4);
                  }
                  $row->image3_4()->create(['url' => $image3_4, 'type' => 11]);
                }
              }
              if(isset($value['image3_5'])) {
                $row->image3_5()->delete();
                if($value['image3_5']) {
                  if(!Str::contains($value['image3_5'], ['uploads','false'])) {
                    $image3_5 = Imageable::uploadImage($value['image3_5']);
                  } else {
                    $image3_5 = explode('/', $value['image3_5']);
                    $image3_5 = end($image3_5);
                  }
                  $row->image3_5()->create(['url' => $image3_5, 'type' => 12]);
                }
              }
              if(isset($value['image3_6'])) {
                $row->image3_6()->delete();
                if($value['image3_6']) {
                  if(!Str::contains($value['image3_6'], ['uploads','false'])) {
                    $image3_6 = Imageable::uploadImage($value['image3_6']);
                  } else {
                    $image3_6 = explode('/', $value['image3_6']);
                    $image3_6 = end($image3_6);
                  }
                  $row->image3_6()->create(['url' => $image3_6, 'type' => 13]);
                }
              }
              if(isset($value['image3_7'])) {
                $row->image3_7()->delete();
                if($value['image3_7']) {
                  if(!Str::contains($value['image3_7'], ['uploads','false'])) {
                    $image3_7 = Imageable::uploadImage($value['image3_7']);
                  } else {
                    $image3_7 = explode('/', $value['image3_7']);
                    $image3_7 = end($image3_7);
                  }
                  $row->image3_7()->create(['url' => $image3_7, 'type' => 14]);
                }
              }
              if(isset($value['image3_8'])) {
                $row->image3_8()->delete();
                if($value['image3_8']) {
                  if(!Str::contains($value['image3_8'], ['uploads','false'])) {
                    $image3_8 = Imageable::uploadImage($value['image3_8']);
                  } else {
                    $image3_8 = explode('/', $value['image3_8']);
                    $image3_8 = end($image3_8);
                  }
                  $row->image3_8()->create(['url' => $image3_8, 'type' => 15]);
                }
              }
              if(isset($value['image3_9'])) {
                $row->image3_9()->delete();
                if($value['image3_9']) {
                  if(!Str::contains($value['image3_9'], ['uploads','false'])) {
                    $image3_9 = Imageable::uploadImage($value['image3_9']);
                  } else {
                    $image3_9 = explode('/', $value['image3_9']);
                    $image3_9 = end($image3_9);
                  }
                  $row->image3_9()->create(['url' => $image3_9, 'type' => 16]);
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
                    $image_pdf = end($pdf);
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
