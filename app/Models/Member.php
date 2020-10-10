<?php

namespace App\Models;

use DB;
use Carbon\Carbon;
use App\Models\Imageable;
use App\Models\MemberCourse;
use App\Models\MemberLanguage;
use App\Models\MemberQualification;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $guarded = [];

    public function image() {
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

    public function courses() {
       return $this->hasMany(MemberCourse::class, 'member_id')
                  ->select('id','program','institute','duration','date_from','date_to','certificate');
    }

    public function languages() {
       return $this->hasMany(MemberLanguage::class, 'member_id')
                  ->select('id','language','level');
    }
    public function qualifcations() {
       return $this->hasMany(MemberQualification::class, 'member_id')
                  ->select('id', 'educational', 'univeristy', 'grade', 'year','date_from','date_to','certificate');
    }


    // fetch Data
    public static function fetchData($value='')
    {
        // this way will fire up speed of the query
        $obj = self::query();


          // search for multiple columns..
          if(isset($value['search']) && $value['search']) {
            $obj->where(function($q) use ($value) {
                $q->where('first_name', 'like', '%'.$value['search'].'%');
                $q->orWhere('middle_name', 'like', '%'.$value['search'].'%');
                $q->orWhere('last_name', 'like', '%'.$value['search'].'%');
                $q->orWhere('email', 'like', '%'.$value['search'].'%');
                $q->orWhere('id', $value['search']);
              });
          }

          if(isset($value['filter']) && $value['filter']) {
                if($value['filter_by'] == 'nationality') {
                  $obj->where('nationality', str_replace('-',' ',$value['nationality']));
                } else if($value['filter_by'] == 'program') {
                  $obj->where('program', str_replace('-',' ',$value['program']));
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
              $row                      = (isset($id)) ? self::findOrFail($id) : new self;
              $row->first_name          = $value['first_name'] ?? NULL;
              $row->middle_name         = $value['middle_name'] ?? NULL;
              $row->last_name           = $value['last_name'] ?? NULL;
              $row->full_name           = $value['full_name'] ?? NULL;
              $row->nationality         = $value['nationality'] ?? NULL;
              $row->residential_address = $value['residential_address'] ?? NULL;
              $row->telephone_no        = $value['telephone_no'] ?? NULL;
              $row->email_Address       = $value['email_Address'] ?? NULL;
              $row->video_url           = $value['video_url'] ?? NULL;

              $row->reefer           = (isset($value['reefer']) && $value['reefer'])
                                            ? $value['reefer'] : NULL;
              $row->save();

              // files
              if(isset($value['passport_file'])) {
                if($value['passport_file']) {
                  $file1 = Imageable::uploadImage($value['passport_file']);
                  $row->file1()->delete();
                  $row->file1()->create(['url' => $file1, 'is_pdf' => 1]);
                }
              }
              if(isset($value['passport_size_file'])) {
                if($value['passport_size_file']) {
                  $file2 = Imageable::uploadImage($value['passport_size_file']);
                  $row->file2()->delete();
                  $row->file2()->create(['url' => $file2, 'is_pdf' => 2]);
                }
              }
              if(isset($value['occupation_file'])) {
                if($value['occupation_file']) {
                  $file3 = Imageable::uploadImage($value['occupation_file']);
                  $row->file3()->delete();
                  $row->file3()->create(['url' => $file3, 'is_pdf' => 3]);
                }
              }
              if(isset($value['detailed_resume'])) {
                if($value['detailed_resume']) {
                  $file4 = Imageable::uploadImage($value['detailed_resume']);
                  $row->file4()->delete();
                  $row->file4()->create(['url' => $file4, 'is_pdf' => 4]);
                }
              }
              if(isset($value['hr_letter_file'])) {
                if($value['hr_letter_file']) {
                  $file5 = Imageable::uploadImage($value['hr_letter_file']);
                  $row->file5()->delete();
                  $row->file5()->create(['url' => $file5, 'is_pdf' => 5]);
                }
              }
             

              // Image
              if(isset($value['base64Image'])) {
                if($value['base64Image']) {
                  $image = Imageable::uploadImage($value['base64Image']);
                  $row->image()->delete();
                  $row->image()->create(['url' => $image]);
                }
              }

              if(isset($value['courses']) && count($value['courses'])) {
                $row->courses()->delete();
                foreach ($value['courses'] as $course) {
                  if(isset($course['program']) && $course['program']) {

                    if($course['certificate']) {
                      $certificate = Imageable::uploadImage($course['certificate']);
                    }
                   $row->courses()->create([
                      'program'   => $course['program'] ?? NULL,
                      'institute' => $course['institute'] ?? NULL,
                      'duration'  => $course['duration'] ?? NULL,
                      'date_from' => $course['date_from'] ?? NULL,
                      'date_to'   => $course['date_to'] ?? NULL,
                      'certificate' => $certificate ?? NULL
                    ]);
                   }
                }
              }


              if(isset($value['languages']) && count($value['languages'])) {
                $row->languages()->delete();
                foreach ($value['languages'] as $lang) {
                  if(isset($lang['language']) && $lang['language']) {
                   $row->languages()->create([
                      'language'   => $lang['language'] ?? NULL,
                      'level'      => $lang['level'] ?? NULL
                    ]);
                  }
                }
              }

              if(isset($value['qualifcations']) && count($value['qualifcations'])) {
                $row->qualifcations()->delete();
                foreach ($value['qualifcations'] as $qual) {
                  if(isset($qual['educational']) && $qual['educational']) {
                    
                   if($qual['certificate']) {
                      $certificate = Imageable::uploadImage($qual['certificate']);
                    }

                   $row->qualifcations()->create([
                      'educational'   => $qual['educational'] ?? NULL,
                      'univeristy'    => $qual['univeristy'] ?? NULL,
                      'grade'         => $qual['grade'] ?? NULL,
                      'year'          => $qual['year'] ?? NULL,
                      'date_from'     => $qual['date_from'] ?? NULL,
                      'date_to'       => $qual['date_to'] ?? NULL,
                      'certificate'   => $certificate ?? NULL
                    ]);
                  }
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
    public static function fetchPeriod($header, $days)
    {
        $operator = '-';
        $percentage = '0%';
        $arrow = 'ti-arrow-down';

        // get Period Day
        $obj = self::fetchPeriodDay($header, $days);

        // find percentage & arrow
        if($days != 'infinity') {
            $obj2 = self::fetchPeriodDay($header, $days);
            if($obj >= $obj2) { $operator = '+'; $arrow = 'ti-arrow-up'; } 
            else { $operator = '-'; $arrow = 'ti-arrow-down'; }

            $diff = 0;
            if($obj > 0 && $obj2) { $diff = $obj / $obj2 * 100; }
            $percentage = $operator.''.$diff.'%';
        }

        $data = ['total'=>$obj, 'percentage'=>$percentage, 'arrow'=>$arrow];
        return $data;
        
    }

    public static function fetchPeriodDay($header, $days)
    {
        $obj = self::where('id','!=', 0);

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
