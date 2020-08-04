<?php

namespace App\Models;

use DB;
use App\Models\User;
use App\Models\Domain;
use App\Models\Tenant;
use App\Models\Imageable;
use App\Models\Destination;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $guarded = [];

    public function tenant() {
        return $this->belongsTo(Tenant::class, 'tenant_id')
                    ->where('tenant_id', Domain::getTenantId());
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function destination() {
        return $this->belongsTo(Destination::class, 'destination_id');
    }

    public function image() {
        return $this->morphOne(Imageable::class, 'imageable')
                    ->select('image_url', 'image_alt', 'image_title');
    }


    // fetch Data
    public static function fetchData($value='')
    {
        // this way will fire up speed of the query
        $obj = self::query();

          // get only his tenants
          $obj->has('tenant');

          // search for multiple columns..
          if(isset($value['search'])) {
            $obj->where(function($q){
                $q->where('name', 'like', '%'.$value['search'].'%');
                $q->orWhere('title', 'like', '%'.$value['search'].'%');
                $q->orWhere('id', $value['search']);
              });
          }

          // status
          if(isset($value['status'])) {
              if($value['status'] == 'active')
                  $obj->where(['status' => true, 'trash' => false]);
              else if ($value['status'] == 'inactive')
                  $obj->where(['status' => false, 'trash' => false]);
              else if ($value['status'] == 'trash')
                  $obj->where('trash', true);
          }

          // order By..
          if(isset($value['order'])) {
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
              $row                 = (isset($id)) ? self::findOrFail($id) : new self;
              $row->tenant_id      = Domain::getTenantId();
              $row->user_id        = auth()->guard('api')->user()->id;
              $row->destination_id = $value['destination_id'] ?? NULL;
              $row->name           = $value['name'] ?? NULL;
              $row->title          = $value['title'] ?? NULL;
              $row->body           = $value['body'] ?? NULL;
              $row->stars          = $value['start'] ?? NULL;
              $row->review_numbers = $value['review_numbers'] ?? NULL;
              $row->place          = $value['place'] ?? NULL;
              $row->email          = $value['email'] ?? NULL;
              $row->view_in_home   = $value['view_in_home'] ?? false;
              $row->status         = $value['status'] ?? false;
              $row->save();

              // Image
              if(isset($value['image_url'])) {
                $image = Image::uploadImage($value['image_url'], 'review', 0, 'reviews');
                $row->image()->delete();
                $row->image()->create([
                    'image_url'       => $image,
                    'image_alt'       => $value['image_alt'] ?? NULL,
                    'image_title'     => $value['image_title'] ?? NULL
                ]);
              }


            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

}
