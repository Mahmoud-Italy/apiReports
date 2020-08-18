<?php

namespace App\Models;

use DB;
use App\Models\User;
use App\Models\Domain;
use App\Models\Tenant;
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
              $row->tenant_id   = Domain::getTenantId();
              $row->user_id     = auth()->guard('api')->user()->id;
              $row->mime_type   = \File::mimeType($value['file']);
              $row->size        = $this->filesize_formatted($value['file']);
              $row->save();

              // image
              if(isset($value['base64Image'])) {
                if($value['base64Image']) {
                  $image = Imageable::uploadImage($value['base64Image']);
                  $row->image()->delete();
                  $row->image()->create(['url' => $image]);
                }
              }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }


    public function filesize_formatted($path)
    {
        $size = filesize($path);
        $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }

}
