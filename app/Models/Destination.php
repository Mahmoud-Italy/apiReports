<?php

namespace App\Models;

use DB;
use App\Models\Tag;
use App\Models\User;
use App\Models\Domain;
use App\Models\Tenant;
use App\Models\Metable;
use App\Models\Imageable;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $guarded = [];

    public function tenant() {
        return $this->belongsTo(Tenant::class, 'tenant_id')
                    ->where('tenant_id', Domain::getTenantId());
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function meta() {
        return $this->morphOne(Metable::class, 'metable')
                    ->select('meta_title', 'meta_keywords', 'meta_description');
    }

    public function image() {
        return $this->morphOne(Imageable::class, 'imageable')
                    ->select('image_url', 'image_alt', 'image_title');
    }

    public function childs() {
        return $this->hasMany(__NAMESPACE__.'\\'.class_basename(new self), 'parent_id'); 
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
                $q->where('slug', 'like', '%'.$value['search'].'%');
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
              $row              = (isset($id)) ? self::findOrFail($id) : new self;
              $row->tenant_id   = Domain::getTenantId();
              $row->user_id     = auth()->guard('api')->user()->id;
              $row->parent_id   = $value['parent_id'] ?? NULL;
              $row->slug        = $value['slug'] ?? NULL;
              $row->title       = $value['title'] ?? NULL;
              $row->body        = $value['body'] ?? NULL;
              $row->status      = $value['status'] ?? false;
              $row->save();


              // Metas
              if(isset($value['meta_title'])) {
                $row->meta()->delete();
                $row->meta()->create([
                    'meta_title'       => $value['meta_title'],
                    'meta_keywords'    => $value['meta_keywords'],
                    'meta_description' => $value['meta_description']
                ]);
              }


              // Image
              if(isset($value['image_url'])) {
                $image = Image::uploadImage($value['image_url'], 'destination', 0, 'destinations');
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
