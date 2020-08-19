<?php

namespace App\Models;

use DB;
use App\Models\Imageable;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $guarded = [];


    public function image() {
        return $this->morphOne(Imageable::class, 'imageable')->select('url');
    }



    // fetch Data
    public static function fetchData($value='')
    {
        // this way will fire up speed of the query
        $obj = self::query();

          // search for multiple columns..
          if(isset($value['search'])) {
            $obj->where(function($q){
                $q->where('mime_type', 'like', '%'.$value['search'].'%');
                $q->orWhere('size', 'like', '%'.$value['search'].'%');
                $q->orWhere('id', $value['search']);
              });
          }

          // order By..
          if(isset($value['order'])) {
            if($value['order_by'] == 'mime_type')
              $obj->orderBy('mime_type', $value['order']);
            else if ($value['order_by'] == 'size')
              $obj->orderBy('size', $value['order']);
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
              $row              = (isset($id)) ? self::findOrFail($id) : new self;
              $row->mime_type   = self::mimeType($value['file']);
              $row->size        = self::filesize_formatted($value['file']);
              $row->save();

              // file
              if(isset($value['file'])) {
                if($value['file']) {
                  $file = Imageable::uploadImage($value['file']);
                  $row->image()->delete();
                  $row->image()->create(['url' => $file]);
                }
              }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public static function mimeType($file='')
    {
        $base64_str   = substr($file, strpos($file, ",")+1);
        $imageDecoded = base64_decode($base64_str);
        if(explode(';', $file)[0]) {
          $fileType   = explode(';', $file)[0];
          $fileType   = explode(':', $fileType)[1];
        }
        return $fileType;
    }
    public static function filesize_formatted($path)
    {
        return '512 KB';
        //$size  = filesize($path);
        //$units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        //$power = $size > 0 ? floor(log($size, 1024)) : 0;
        //return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }

    public static function getFileSize($value='')
    {
        $size = [];
        $rows = self::all();
        foreach ($rows as $row) {
            $type = explode(' ',$row->size)[1];
                if($type == 'KB') {
                    $size[] = explode(' ',$row->size)[0] * 1000;
                } else if ($type == 'MB') {
                    $size[] = explode(' ',$row->size)[0] * 1000000;
                }
        }
        return self::calculate_size(array_sum($size));
    }

    public static function calculate_size($size='')
    {
        $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }

}
