<?php

namespace App\Models;

use DB;
use Carbon\Carbon;
use App\Models\Imageable;
use Illuminate\Database\Eloquent\Model;

class NewApp extends Model
{
    protected $guarded = [];

    public function logo() {
        return $this->morphOne(Imageable::class, 'imageable')->where('is_pdf', 0)->select('url');
    }

    public function file1() {
        return $this->morphOne(Imageable::class, 'imageable')->where('is_pdf', 1)->select('url');
    }
    public function file2() {
        return $this->morphOne(Imageable::class, 'imageable')->where('is_pdf', 2)->select('url');
    }
    public function file3() {
        return $this->morphOne(Imageable::class, 'imageable')->where('is_pdf', 3)->select('url');
    }
    public function file4() {
        return $this->morphOne(Imageable::class, 'imageable')->where('is_pdf', 4)->select('url');
    }
    public function file5() {
        return $this->morphOne(Imageable::class, 'imageable')->where('is_pdf', 5)->select('url');
    }
    public function file6() {
        return $this->morphOne(Imageable::class, 'imageable')->where('is_pdf', 6)->select('url');
    }

    public function file7() {
        return $this->morphOne(Imageable::class, 'imageable')->where('is_pdf', 7)->select('url');
    }




    // fetch Data
    public static function fetchData($value='',$id)
    {
        // this way will fire up speed of the query
        $obj = self::query();

          $obj->where('is_accreditation', $id);

          // search for multiple columns..
          if(isset($value['search']) && $value['search']) {
            $obj->where(function($q) use ($value) {
                $q->where('name', 'like', '%'.$value['search'].'%');
                $q->orWhere('email_address', 'like', '%'.$value['search'].'%');
                $q->orWhere('id', $value['search']);
              });
          }

          // Filter By..
            if(isset($value['filter']) && $value['filter']) {
                if($value['filter_by'] == 'nationality') {
                  $obj->where('country', str_replace('-',' ',$value['filter']));
                }
            }

          // status
          if(isset($value['status']) && $value['status']) {
              if($value['status'] == 'seen')
                  $obj->where(['status' => true, 'trash' => false]);
              else if ($value['status'] == 'unseen')
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
              $row                      = (isset($id)) ? self::findOrFail($id) : new self;
              $row->is_accreditation    = $value['type_id'] ?? false;
              $row->pname               = (isset($value['pname']) && $value['pname'])
                                            ? $value['pname'] : NULL;
              $row->name_of_institution = $value['name_of_institution'] ?? NULL;
              $row->address             = $value['address'] ?? NULL;
              $row->country             = $value['country'] ?? NULL;
              $row->state               = $value['state'] ?? NULL;
              $row->type                = $value['type'] ?? NULL;
              $row->establishment_date  = $value['establishment_date'] ?? NULL;
              $row->commerical_register_no = $value['commerical_register_no'] ?? NULL;
              $row->telephone_no        = $value['telephone_no'] ?? NULL;
              $row->email_address       = $value['email_address'] ?? NULL;
              $row->website_url         = $value['website_url'] ?? NULL;

              $row->general1            = (boolean)$value['general1'] ?? false;
              $row->general2            = (boolean)$value['general2'] ?? false;
              $row->general3            = (boolean)$value['general3'] ?? false;
              $row->general4            = (boolean)$value['general4'] ?? false;
              $row->general5            = (boolean)$value['general5'] ?? false;


              $row->authority1          = (boolean)$value['authority1'] ?? false;
              $row->authority2          = (boolean)$value['authority2'] ?? false;
              $row->authority3          = (boolean)$value['authority3'] ?? false;
              $row->authority4          = (boolean)$value['authority4'] ?? false;
              $row->authority5          = (boolean)$value['authority5'] ?? false;
              $row->authority6          = (boolean)$value['authority6'] ?? false;

              $row->name                = $value['name'] ?? NULL;
              $row->date                = $value['date'] ?? NULL;
              // $row->reefer           = (isset($value['reefer']) && $value['reefer'])
              //                               ? $value['reefer'] : NULL;
              $row->save();



              // logo
              if(isset($value['logo'])) {
                if($value['logo']) {
                  $logo = Imageable::uploadImage($value['logo']);
                  $row->logo()->delete();
                  $row->logo()->create(['url' => $logo]);
                }
              }

              // files
              if(isset($value['file1'])) {
                if($value['file1']) {
                  $file1 = Imageable::uploadImage($value['file1']);
                  $row->file1()->delete();
                  $row->file1()->create(['url' => $file1, 'is_pdf' => 1]);
                }
              }
              if(isset($value['file2'])) {
                if($value['file2']) {
                  $file2 = Imageable::uploadImage($value['file2']);
                  $row->file2()->delete();
                  $row->file2()->create(['url' => $file2, 'is_pdf' => 2]);
                }
              }
              if(isset($value['file3'])) {
                if($value['file3']) {
                  $file3 = Imageable::uploadImage($value['file3']);
                  $row->file3()->delete();
                  $row->file3()->create(['url' => $file3, 'is_pdf' => 3]);
                }
              }
              if(isset($value['file4'])) {
                if($value['file4']) {
                  $file4 = Imageable::uploadImage($value['file4']);
                  $row->file4()->delete();
                  $row->file4()->create(['url' => $file4, 'is_pdf' => 4]);
                }
              }
              if(isset($value['file5'])) {
                if($value['file5']) {
                  $file5 = Imageable::uploadImage($value['file5']);
                  $row->file5()->delete();
                  $row->file5()->create(['url' => $file5, 'is_pdf' => 5]);
                }
              }
              if(isset($value['file6'])) {
                if($value['file6']) {
                  $file6 = Imageable::uploadImage($value['file6']);
                  $row->file6()->delete();
                  $row->file6()->create(['url' => $file6, 'is_pdf' => 6]);
                }
              }
              if(isset($value['file7'])) {
                if($value['file7']) {
                  $file7 = Imageable::uploadImage($value['file7']);
                  $row->file7()->delete();
                  $row->file7()->create(['url' => $file7, 'is_pdf' => 7]);
                }
              }


            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }






  // fetch Period
    public static function fetchPeriod($header, $days, $isType)
    {
        $operator = '-';
        $percentage = '0%';
        $arrow = 'ti-arrow-down';

        // get Period Day
        $obj = self::fetchPeriodDay($header, $days, $isType);

        // find percentage & arrow
        if($days != 'infinity') {
            $obj2 = self::fetchPeriodDay($header, $days, $isType);
            if($obj >= $obj2) { $operator = '+'; $arrow = 'ti-arrow-up'; } 
            else { $operator = '-'; $arrow = 'ti-arrow-down'; }

            $diff = 0;
            if($obj > 0 && $obj2) { $diff = $obj / $obj2 * 100; }
            $percentage = $operator.''.$diff.'%';
        }

        $data = ['total'=>$obj, 'percentage'=>$percentage, 'arrow'=>$arrow];
        return $data;
        
    }

  public static function fetchPeriodDay($header, $days, $isType)
    {
        $obj = self::where('is_accreditation', $isType);

            // Today & else = Yesterday, 28 Days, 90 Days , 180 Days
            if($days == 0) {
                $obj = $obj->whereDate('created_at', Carbon::now());
            } else if ($days != 0 && $days != 'infinity') {
                $obj = $obj->whereDate('created_at', '>=', Carbon::now()->subDay($days));
            } 

        $obj = $obj->count();
        return $obj;
    }
}
