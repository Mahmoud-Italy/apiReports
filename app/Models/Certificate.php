<?php

namespace App\Models;

use DB;
use App\Models\Imageable;
use Illuminate\Support\Str;
use App\Models\CertificateCategory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $guarded = [];


    public function image_pdf() {
        return $this->morphOne(Imageable::class, 'imageable')
                      ->where('type', 9)
                      ->select('url');
    }


    public function image1() {
        return $this->morphOne(Imageable::class, 'imageable')
                      ->where('type', 1)
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
    public function image4() {
        return $this->morphOne(Imageable::class, 'imageable')
                      ->where('type', 4)
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
              $row->duration       = $value['duration'] ?? NULL;

              $row->dTitle         = $value['dTitle'] ?? NULL;
              
              $row->cTitle         = $value['cTitle'] ?? NULL;
              $row->cBody          = $value['cBody'] ?? NULL;

              $row->download_name  = $value['download_name'] ?? NULL;
              $row->has_download   = (boolean)$value['has_download'] ?? false;
              $row->save();


              if(isset($value['image1'])) {
                $row->image1()->delete();
                if($value['image1']) {
                  if(!Str::contains($value['image1'], ['uploads','false'])) {
                    $image1 = Imageable::uploadImage($value['image1']);
                  } else {
                    $image1 = explode('/', $value['image1']);
                    $image1 = end($image1);
                  }
                  $row->image1()->create(['url' => $image1, 'type' => 1]);
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
                  $row->image_pdf()->create(['url' => $pdf_file, 'type' => 9]);
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


              if(isset($value['image4'])) {
                $row->image4()->delete();
                if($value['image4']) {
                  if(!Str::contains($value['image4'], ['uploads','false'])) {
                    $image4 = Imageable::uploadImage($value['image4']);
                  } else {
                    $image4 = explode('/', $value['image4']);
                    $image4 = end($image4);
                  }
                  $row->image4()->create(['url' => $image4, 'type' => 4]);
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




            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

}
