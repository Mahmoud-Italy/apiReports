<?php

namespace App\Models;

use DB;
use App\Models\Imageable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class OnlineTraining extends Model
{
    protected $guarded = [];

    public function image() {
        return $this->morphOne(Imageable::class, 'imageable')
                  ->where('type', false)
                  ->where('is_pdf', false)
                  ->select('url');
    }


    public function image1_1() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 1)->select('url');
    }
    public function image1_2() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 2)->select('url');
    }
    public function image1_3() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 3)->select('url');
    }
    public function image1_4() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 4)->select('url');
    }
    public function image1_5() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 5)->select('url');
    }

    public function image2_1() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 51)->select('url');
    }
    public function image2_2() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 6)->select('url');
    }
    public function image2_3() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 7)->select('url');
    }
    public function image2_4() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 8)->select('url');
    }


    public function image3_1() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 9)->select('url');
    }
    public function image3_2() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 10)->select('url');
    }
    public function image3_3() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 11)->select('url');
    }
    public function image3_4() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 12)->select('url');
    }
    public function image3_5() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 13)->select('url');
    }
    public function image3_6() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 14)->select('url');
    }
    public function image3_7() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 15)->select('url');
    }
    public function image3_8() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 16)->select('url');
    }
    public function image3_9() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 17)->select('url');
    }

    public function image4_1() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 18)->select('url');
    }
    public function image4_2() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 19)->select('url');
    }
    public function image4_3() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 20)->select('url');
    }
    public function image4_4() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 21)->select('url');
    }

    public function image5_1() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 22)->select('url');
    }
    public function image5_2() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 23)->select('url');
    }
    public function image5_3() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 24)->select('url');
    }
    public function image5_4() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 25)->select('url');
    }

    public function image6_1() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 26)->select('url');
    }
    public function image6_2() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 27)->select('url');
    }
    public function image6_3() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 28)->select('url');
    }
    public function image6_4() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 29)->select('url');
    }



    public function pdf() {
        return $this->morphOne(Imageable::class, 'imageable')->where('is_pdf', 1)->select('url');
    }
    public function image_pdf() {
        return $this->morphOne(Imageable::class, 'imageable')->where('is_pdf', 2)->select('url');
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


              $row->body1_1       = $value['body1_1'] ?? NULL;

              $row->line1_2       = $value['line1_2'] ?? NULL;
              $row->mask1_2       = $value['mask1_2'] ?? NULL;
              $row->color1_2      = $value['color1_2'] ?? NULL;
              $row->body1_2_1     = $value['body1_2_1'] ?? NULL;
              $row->body1_2_2     = $value['body1_2_2'] ?? NULL;

              $row->line1_3       = $value['line1_3'] ?? NULL;
              $row->mask1_3       = $value['mask1_3'] ?? NULL;
              $row->color1_3      = $value['color1_3'] ?? NULL;
              $row->body1_3_1     = $value['body1_3_1'] ?? NULL;
              $row->body1_3_2     = $value['body1_3_2'] ?? NULL;

              $row->line1_4       = $value['line1_4'] ?? NULL;
              $row->mask1_4       = $value['mask1_4'] ?? NULL;
              $row->color1_4      = $value['color1_4'] ?? NULL;
              $row->body1_4_1     = $value['body1_4_1'] ?? NULL;
              $row->body1_4_2     = $value['body1_4_2'] ?? NULL;

              $row->line1_5       = $value['line1_5'] ?? NULL;
              $row->mask1_5       = $value['mask1_5'] ?? NULL;
              $row->color1_5      = $value['color1_5'] ?? NULL;
              $row->body1_5_1     = $value['body1_5_1'] ?? NULL;
              $row->body1_5_2     = $value['body1_5_2'] ?? NULL;


              $row->line2_1       = $value['line2_1'] ?? NULL;
              $row->mask2_1       = $value['mask2_1'] ?? NULL;
              $row->color2_1      = $value['color2_1'] ?? NULL;
              $row->body2_1       = $value['body2_1'] ?? NULL;

              $row->line2_2       = $value['line2_2'] ?? NULL;
              $row->mask2_2       = $value['mask2_2'] ?? NULL;
              $row->color2_2      = $value['color2_2'] ?? NULL;
              $row->body2_2       = $value['body2_2'] ?? NULL;

              $row->line2_3       = $value['line2_3'] ?? NULL;
              $row->mask2_3       = $value['mask2_3'] ?? NULL;
              $row->color2_3      = $value['color2_3'] ?? NULL;
              $row->body2_3       = $value['body2_3'] ?? NULL;

              $row->line2_4       = $value['line2_4'] ?? NULL;
              $row->mask2_4       = $value['mask2_4'] ?? NULL;
              $row->color2_4      = $value['color2_4'] ?? NULL;
              $row->body2_4       = $value['body2_4'] ?? NULL;

              $row->body3_1       = $value['body3_1'] ?? NULL;
              $row->body3_2       = $value['body3_2'] ?? NULL;
              $row->body3_3       = $value['body3_3'] ?? NULL;
              $row->body3_4       = $value['body3_4'] ?? NULL;
              $row->body3_5       = $value['body3_5'] ?? NULL;
              $row->body3_6       = $value['body3_6'] ?? NULL;
              $row->body3_7       = $value['body3_7'] ?? NULL;
              $row->body3_8       = $value['body3_8'] ?? NULL;
              $row->body3_9       = $value['body3_9'] ?? NULL;

              $row->body4_1       = $value['body4_1'] ?? NULL;
              $row->body4_2       = $value['body4_2'] ?? NULL;
              $row->body4_3       = $value['body4_3'] ?? NULL;
              $row->body4_4       = $value['body4_4'] ?? NULL;

              $row->line5_1       = $value['line5_1'] ?? NULL;
              $row->mask5_1       = $value['mask5_1'] ?? NULL;
              $row->color5_1      = $value['color5_1'] ?? NULL;
              $row->body5_1       = $value['body5_1'] ?? NULL;

              $row->line5_2       = $value['line5_2'] ?? NULL;
              $row->mask5_2       = $value['mask5_2'] ?? NULL;
              $row->color5_2      = $value['color5_2'] ?? NULL;
              $row->body5_2       = $value['body5_2'] ?? NULL;

              $row->line5_3       = $value['line5_3'] ?? NULL;
              $row->mask5_3       = $value['mask5_3'] ?? NULL;
              $row->color5_3      = $value['color5_3'] ?? NULL;
              $row->body5_3       = $value['body5_3'] ?? NULL;

              $row->line5_4       = $value['line5_4'] ?? NULL;
              $row->mask5_4       = $value['mask5_4'] ?? NULL;
              $row->color5_4      = $value['color5_4'] ?? NULL;
              $row->body5_4      = $value['body5_4'] ?? NULL;
              
              $row->body6_1       = $value['body6_1'] ?? NULL;
              $row->body6_2       = $value['body6_2'] ?? NULL;
              $row->body6_3       = $value['body6_3'] ?? NULL;
              $row->body6_4       = $value['body6_4'] ?? NULL;


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


              // $row->has_programs    = (isset($value['has_programs']) && $value['has_programs']) 
              //                           ? (boolean)$value['has_programs'] 
              //                           : false;
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



              if(isset($value['image1_1'])) {
                $row->image1_1()->delete();
                if($value['image1_1']) {
                  if(!Str::contains($value['image1_1'], ['uploads','false'])) {
                    $image1_1 = Imageable::uploadImage($value['image1_1']);
                  } else {
                    $image1_1 = explode('/', $value['image1_1']);
                    $image1_1 = end($image1_1);
                  }
                  $row->image1_1()->create(['url' => $image1_1, 'type' => 1]);
                }
              }
              if(isset($value['image1_2'])) {
                $row->image1_2()->delete();
                if($value['image1_2']) {
                  if(!Str::contains($value['image1_2'], ['uploads','false'])) {
                    $image1_2 = Imageable::uploadImage($value['image1_2']);
                  } else {
                    $image1_2 = explode('/', $value['image1_2']);
                    $image1_2 = end($image1_2);
                  }
                  $row->image1_2()->create(['url' => $image1_2, 'type' => 2]);
                }
              }
              if(isset($value['image1_3'])) {
                $row->image1_3()->delete();
                if($value['image1_3']) {
                  if(!Str::contains($value['image1_3'], ['uploads','false'])) {
                    $image1_3 = Imageable::uploadImage($value['image1_3']);
                  } else {
                    $image1_3 = explode('/', $value['image1_3']);
                    $image1_3 = end($image1_3);
                  }
                  $row->image1_3()->create(['url' => $image1_3, 'type' => 3]);
                }
              }
              if(isset($value['image1_4'])) {
                $row->image1_4()->delete();
                if($value['image1_4']) {
                  if(!Str::contains($value['image1_4'], ['uploads','false'])) {
                    $image1_4 = Imageable::uploadImage($value['image1_4']);
                  } else {
                    $image1_4 = explode('/', $value['image1_4']);
                    $image1_4 = end($image1_4);
                  }
                  $row->image1_4()->create(['url' => $image1_4, 'type' => 4]);
                }
              }
              if(isset($value['image1_5'])) {
                $row->image1_5()->delete();
                if($value['image1_5']) {
                  if(!Str::contains($value['image1_4'], ['uploads','false'])) {
                    $image1_5 = Imageable::uploadImage($value['image1_5']);
                  } else {
                    $image1_5 = explode('/', $value['image1_5']);
                    $image1_5 = end($image1_5);
                  }
                  $row->image1_5()->create(['url' => $image1_5, 'type' => 5]);
                }
              }




              if(isset($value['image2_1'])) {
                $row->image2_1()->delete();
                if($value['image2_1']) {
                  if(!Str::contains($value['image2_1'], ['uploads','false'])) {
                    $image2_1 = Imageable::uploadImage($value['image2_1']);
                  } else {
                    $image2_1 = explode('/', $value['image2_1']);
                    $image2_1 = end($image2_1);
                  }
                  $row->image2_1()->create(['url' => $image2_1, 'type' => 51]);
                }
              }
              if(isset($value['image2_2'])) {
                $row->image2_2()->delete();
                if($value['image2_2']) {
                  if(!Str::contains($value['image2_2'], ['uploads','false'])) {
                    $image2_2 = Imageable::uploadImage($value['image2_2']);
                  } else {
                    $image2_2 = explode('/', $value['image2_2']);
                    $image2_2 = end($image2_2);
                  }
                  $row->image2_2()->create(['url' => $image2_2, 'type' => 6]);
                }
              }
              if(isset($value['image2_3'])) {
                $row->image2_3()->delete();
                if($value['image2_3']) {
                  if(!Str::contains($value['image2_3'], ['uploads','false'])) {
                    $image2_3 = Imageable::uploadImage($value['image2_3']);
                  } else {
                    $image2_3 = explode('/', $value['image2_3']);
                    $image2_3 = end($image2_3);
                  }
                  $row->image2_3()->create(['url' => $image2_3, 'type' => 7]);
                }
              }
              if(isset($value['image2_4'])) {
                $row->image2_4()->delete();
                if($value['image2_4']) {
                  if(!Str::contains($value['image2_4'], ['uploads','false'])) {
                    $image2_4 = Imageable::uploadImage($value['image2_4']);
                  } else {
                    $image2_4 = explode('/', $value['image2_4']);
                    $image2_4 = end($image2_4);
                  }
                  $row->image2_4()->create(['url' => $image2_4, 'type' => 8]);
                }
              }




              if(isset($value['image3_1'])) {
                $row->image3_1()->delete();
                if($value['image3_1']) {
                  if(!Str::contains($value['image3_1'], ['uploads','false'])) {
                    $image3_1 = Imageable::uploadImage($value['image3_1']);
                  } else {
                    $image3_1 = explode('/', $value['image3_1']);
                    $image3_1 = end($image3_1);
                  }
                  $row->image3_1()->create(['url' => $image3_1, 'type' => 9]);
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
                  $row->image3_2()->create(['url' => $image3_2, 'type' => 10]);
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
                  $row->image3_3()->create(['url' => $image3_3, 'type' => 11]);
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
                  $row->image3_4()->create(['url' => $image3_4, 'type' => 12]);
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
                  $row->image3_5()->create(['url' => $image3_5, 'type' => 13]);
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
                  $row->image3_6()->create(['url' => $image3_6, 'type' => 14]);
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
                  $row->image3_7()->create(['url' => $image3_7, 'type' => 15]);
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
                  $row->image3_8()->create(['url' => $image3_8, 'type' => 16]);
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
                  $row->image3_9()->create(['url' => $image3_9, 'type' => 17]);
                }
              }



              if(isset($value['image4_1'])) {
                $row->image4_1()->delete();
                if($value['image4_1']) {
                  if(!Str::contains($value['image4_1'], ['uploads','false'])) {
                    $image4_1 = Imageable::uploadImage($value['image4_1']);
                  } else {
                    $image4_1 = explode('/', $value['image4_1']);
                    $image4_1 = end($image4_1);
                  }
                  $row->image4_1()->create(['url' => $image4_1, 'type' => 18]);
                }
              }
              if(isset($value['image4_2'])) {
                $row->image4_2()->delete();
                if($value['image4_2']) {
                  if(!Str::contains($value['image4_2'], ['uploads','false'])) {
                    $image4_2 = Imageable::uploadImage($value['image4_2']);
                  } else {
                    $image4_2 = explode('/', $value['image4_2']);
                    $image4_2 = end($image4_2);
                  }
                  $row->image4_2()->create(['url' => $image4_2, 'type' => 19]);
                }
              }
              if(isset($value['image4_3'])) {
                $row->image4_3()->delete();
                if($value['image4_3']) {
                  if(!Str::contains($value['image4_3'], ['uploads','false'])) {
                    $image4_3 = Imageable::uploadImage($value['image4_3']);
                  } else {
                    $image4_3 = explode('/', $value['image4_3']);
                    $image4_3 = end($image4_3);
                  }
                  $row->image4_3()->create(['url' => $image4_3, 'type' => 20]);
                }
              }
              if(isset($value['image4_4'])) {
                $row->image4_4()->delete();
                if($value['image4_4']) {
                  if(!Str::contains($value['image4_4'], ['uploads','false'])) {
                    $image4_4 = Imageable::uploadImage($value['image4_4']);
                  } else {
                    $image4_4 = explode('/', $value['image4_4']);
                    $image4_4 = end($image4_4);
                  }
                  $row->image4_4()->create(['url' => $image4_4, 'type' => 21]);
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
                  $row->image5_1()->create(['url' => $image5_1, 'type' => 22]);
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
                  $row->image5_2()->create(['url' => $image5_2, 'type' => 23]);
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
                  $row->image5_3()->create(['url' => $image5_3, 'type' => 24]);
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
                  $row->image5_4()->create(['url' => $image5_4, 'type' => 25]);
                }
              }


              if(isset($value['image6_1'])) {
                $row->image6_1()->delete();
                if($value['image6_1']) {
                  if(!Str::contains($value['image6_1'], ['uploads','false'])) {
                    $image6_1 = Imageable::uploadImage($value['image6_1']);
                  } else {
                    $image6_1 = explode('/', $value['image6_1']);
                    $image6_1 = end($image6_1);
                  }
                  $row->image6_1()->create(['url' => $image6_1, 'type' => 26]);
                }
              }
              if(isset($value['image6_2'])) {
                $row->image6_2()->delete();
                if($value['image6_2']) {
                  if(!Str::contains($value['image6_2'], ['uploads','false'])) {
                    $image6_2 = Imageable::uploadImage($value['image6_2']);
                  } else {
                    $image6_2 = explode('/', $value['image6_2']);
                    $image6_2 = end($image6_2);
                  }
                  $row->image6_2()->create(['url' => $image6_2, 'type' => 27]);
                }
              }
              if(isset($value['image6_3'])) {
                $row->image6_3()->delete();
                if($value['image6_3']) {
                  if(!Str::contains($value['image6_3'], ['uploads','false'])) {
                    $image6_3 = Imageable::uploadImage($value['image6_3']);
                  } else {
                    $image6_3 = explode('/', $value['image6_3']);
                    $image6_3 = end($image6_3);
                  }
                  $row->image6_3()->create(['url' => $image6_3, 'type' => 28]);
                }
              }
              if(isset($value['image6_4'])) {
                $row->image6_4()->delete();
                if($value['image6_4']) {
                  if(!Str::contains($value['image6_4'], ['uploads','false'])) {
                    $image6_4 = Imageable::uploadImage($value['image6_4']);
                  } else {
                    $image6_4 = explode('/', $value['image6_4']);
                    $image6_4 = end($image6_4);
                  }
                  $row->image6_4()->create(['url' => $image6_4, 'type' => 29]);
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
