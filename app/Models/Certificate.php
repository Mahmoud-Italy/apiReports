<?php

namespace App\Models;

use DB;
use App\Models\Setting;
use App\Models\Imageable;
use Illuminate\Support\Str;
use App\Models\CertificateCategory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $guarded = [];


    public function image_pdf() {
        return $this->morphOne(Imageable::class, 'imageable')->where('is_pdf', 2)->select('url');
    }
    public function pdf() {
        return $this->morphOne(Imageable::class, 'imageable')->where('is_pdf', 1)->select('url');
    }

    public function image() {
        return $this->morphOne(Imageable::class, 'imageable')
                      ->where('type', 0)
                      ->where('is_pdf', 0)
                      ->select('url');
    }


    public function image2() {
        return $this->morphOne(Imageable::class, 'imageable')
                      ->where('type', 2)
                      ->select('url');
    }
    public function image3() {
        return $this->morphOne(Imageable::class, 'imageable')
                      ->where('type', 3)
                      ->select('url');
    }

    public function image5_1() {
        return $this->morphOne(Imageable::class, 'imageable')
                      ->where('type', 5)
                      ->select('url');
    }
    public function image5_2() {
        return $this->morphOne(Imageable::class, 'imageable')
                      ->where('type', 6)
                      ->select('url');
    }
    public function image5_3() {
        return $this->morphOne(Imageable::class, 'imageable')
                      ->where('type', 7)
                      ->select('url');
    }
    public function image5_4() {
        return $this->morphOne(Imageable::class, 'imageable')
                      ->where('type', 8)
                      ->select('url');
    }

    
    // fetch Data
    public static function fetchData($value='')
    {
        // this way will fire up speed of the query
        $obj = self::query();

          // search for multiple columns..
          if(isset($value['search']) && $value['search']) {
            $obj->where(function($q) use ($value) {
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
              $row->bgTitle1       = $value['bgTitle1'] ?? NULL;
              $row->bgSubTitle1    = $value['bgSubTitle1'] ?? NULL;
              $row->bgColor1       = $value['bgColor1'] ?? NULL;
              $row->body1          = $value['body1'] ?? NULL;

              $row->bgTitle2       = $value['bgTitle2'] ?? NULL;
              $row->bgSubTitle2    = $value['bgSubTitle2'] ?? NULL;
              $row->bgColor2       = $value['bgColor2'] ?? NULL;
              $row->body2          = $value['body2'] ?? NULL;
              $row->hint2          = $value['hint2'] ?? NULL;
              $row->duration1       = $value['duration1'] ?? NULL;
              $row->duration2       = $value['duration2'] ?? NULL;
              $row->duration3       = $value['duration3'] ?? NULL;

              $row->dTitle         = $value['dTitle'] ?? NULL;
              
              $row->cTitle         = $value['cTitle'] ?? NULL;

              $row->cBody1          = $value['cBody1'] ?? NULL;
              $row->cBody2          = $value['cBody2'] ?? NULL;
              $row->cBody3          = $value['cBody3'] ?? NULL;
              $row->cBody4          = $value['cBody4'] ?? NULL;
              $row->cBody5          = $value['cBody5'] ?? NULL;

              $row->download_name  = $value['download_name'] ?? NULL;
              $row->has_download   = (boolean)$value['has_download'] ?? false;
              $row->save();


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


              if(isset($value['image2'])) {
                $row->image2()->delete();
                if($value['image2']) {
                  if(!Str::contains($value['image2'], ['uploads','false'])) {
                    $image2 = Imageable::uploadImage($value['image2']);
                  } else {
                    $image2 = explode('/', $value['image2']);
                    $image2 = end($image2);
                  }
                  $row->image2()->create(['url' => $image2, 'type' => 2]);
                }
              }

              if(isset($value['image3'])) {
                $row->image3()->delete();
                if($value['image3']) {
                  if(!Str::contains($value['image3'], ['uploads','false'])) {
                    $image3 = Imageable::uploadImage($value['image3']);
                  } else {
                    $image3 = explode('/', $value['image3']);
                    $image3 = end($image3);
                  }
                  $row->image3()->create(['url' => $image3, 'type' => 3]);
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
                  $row->image5_1()->create(['url' => $image5_1, 'type' => 5]);
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
                  $row->image5_2()->create(['url' => $image5_2, 'type' => 6]);
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
                  $row->image5_3()->create(['url' => $image5_3, 'type' => 7]);
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
                  $row->image5_4()->create(['url' => $image5_4, 'type' => 8]);
                }
              }



              // catss
              if(isset($value['cat1'])) {
                CertificateCategory::where('cat_id', 1)->delete();
                if(count($value['cat1'])) {
                foreach($value['cat1'] as $cat1) {
                  if($cat1['cat_title']) {
                    $row1 = new CertificateCategory;
                    $row1->cat_id = 1;
                    $row1->title = $cat1['cat_title'];
                    $row1->save();

                      if(isset($cat1['cat_image'])) {
                          $row1->image()->delete();
                          if($cat1['cat_image']) {
                            if(!Str::contains($cat1['cat_image'], ['uploads','false'])) {
                              $image = Imageable::uploadImage($cat1['cat_image']);
                            } else {
                              $image = explode('/', $cat1['cat_image']);
                              $image = end($image);
                            }
                            $row1->image()->create(['url' => $image, 'type' => 0]);
                          }
                        }

                        if(isset($cat1['cat_pdf'])) {
                          $row1->pdf()->delete();
                          if($cat1['cat_pdf']) {
                            if(!Str::contains($cat1['cat_pdf'], ['uploads','false'])) {
                              $pdf = Imageable::uploadImage($cat1['cat_pdf']);
                            } else {
                              $pdf = explode('/', $cat1['cat_pdf']);
                              $pdf = end($pdf);
                            }
                            $row1->pdf()->create(['url' => $pdf, 'type' => 1]);
                          }
                        }
                    }
                  }
                }
              }


              // catss
              if(isset($value['cat2'])) {
                CertificateCategory::where('cat_id', 2)->delete();
                if(count($value['cat2'])) {
                foreach($value['cat2'] as $cat2) {
                  if($cat2['cat_title']) {
                    $row2 = new CertificateCategory;
                    $row2->cat_id = 2;
                    $row2->title = $cat2['cat_title'];
                    $row2->save();

                      if(isset($cat2['cat_image'])) {
                          $row2->image()->delete();
                          if($cat2['cat_image']) {
                            if(!Str::contains($cat2['cat_image'], ['uploads','false'])) {
                              $image = Imageable::uploadImage($cat2['cat_image']);
                            } else {
                              $image = explode('/', $cat2['cat_image']);
                              $image = end($image);
                            }
                            $row2->image()->create(['url' => $image, 'type' => 0]);
                          }
                        }

                        if(isset($cat2['cat_pdf'])) {
                          $row2->pdf()->delete();
                          if($cat2['cat_pdf']) {
                            if(!Str::contains($cat2['cat_pdf'], ['uploads','false'])) {
                              $pdf = Imageable::uploadImage($cat2['cat_pdf']);
                            } else {
                              $pdf = explode('/', $cat2['cat_pdf']);
                              $pdf = end($pdf);
                            }
                            $row2->pdf()->create(['url' => $pdf, 'type' => 1]);
                          }
                        } 
                    }
                  }
                }
              }



              if(isset($value['cat3'])) {
                CertificateCategory::where('cat_id', 3)->delete();
                if(count($value['cat3'])) {
                foreach($value['cat3'] as $cat3) {
                  if($cat3['cat_title']) {
                    $row3 = new CertificateCategory;
                    $row3->cat_id = 3;
                    $row3->title = $cat3['cat_title'];
                    $row3->save();
                      if(isset($cat3['cat_image'])) {
                          $row3->image()->delete();
                          if($cat3['cat_image']) {
                            if(!Str::contains($cat3['cat_image'], ['uploads','false'])) {
                              $image = Imageable::uploadImage($cat3['cat_image']);
                            } else {
                              $image = explode('/', $cat3['cat_image']);
                              $image = end($image);
                            }
                            $row3->image()->create(['url' => $image, 'type' => 0]);
                          }
                        }

                        if(isset($cat3['cat_pdf'])) {
                          $row3->pdf()->delete();
                          if($cat3['cat_pdf']) {
                            if(!Str::contains($cat3['cat_pdf'], ['uploads','false'])) {
                              $pdf = Imageable::uploadImage($cat3['cat_pdf']);
                            } else {
                              $pdf = explode('/', $cat3['cat_pdf']);
                              $pdf = end($pdf);
                            }
                            $row3->pdf()->create(['url' => $pdf, 'type' => 1]);
                          }
                        }
                      }
                  }
                }
              }




              $setting = Setting::findOrFail(6);
              $setting->body1 = $value['cat1_name'];
              $setting->body2 = $value['cat2_name'];
              $setting->body3 = $value['cat3_name'];
              $setting->save();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

}
