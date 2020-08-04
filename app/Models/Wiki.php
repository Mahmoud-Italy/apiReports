<?php

namespace App\Models;

use DB;
use App\Models\Tag;
use App\Models\User;
use App\Models\Domain;
use App\Models\Tenant;
use App\Models\Metable;
use App\Models\WikiItem;
use App\Models\Imageable;
use App\Models\Destination;
use App\Models\WikiPackage;
use Illuminate\Database\Eloquent\Model;

class Wiki extends Model
{
    protected $guarded = [];

    public function tenant() {
        return $this->belongsTo(Tenant::class, 'tenant_id')->where('tenant_id', Domain::getTenantId());
    }
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function destination() {
        return $this->belongsTo(Destination::class, 'destination_id');
    }


    public function meta() {
        return $this->morphOne(Metable::class, 'metable')
                    ->select('meta_title', 'meta_keywords', 'meta_description');
    }
    public function image() {
        return $this->morphOne(Imageable::class, 'imageable')
                    ->select('image_url', 'image_alt', 'image_title');
    }


    public function tags() {
        return $this->morphMany(Taggable::class, 'taggable');
    }
    public function items() {
        return $this->hasMany(WikiItem::class, 'wiki_id');
    }
    public function packages() {
        return $this->hasMany(WikiPackage::class,'wiki_id');
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
              $row                 = (isset($id)) ? self::findOrFail($id) : new self;
              $row->tenant_id      = Domain::getTenantId();
              $row->user_id        = auth()->guard('api')->user()->id;
              $row->destination_id = $value['destination_id'] ?? NULL;
              $row->title          = $value['title'] ?? NULL;
              $row->body           = $value['body'] ?? NULL;
              $row->short_body     = $value['short_body'] ?? NULL;
              $row->order          = $value['order'] ?? NULL;
              $row->view_in_home   = $value['view_in_home'] ?? false;
              $row->status         = $value['status'] ?? false;
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
                $image = Image::uploadImage($value['image_url'], 'wiki');
                $row->image()->delete();
                $row->image()->create([
                    'image_url'       => $image,
                    'image_alt'       => $value['image_alt'] ?? NULL,
                    'image_title'     => $value['image_title'] ?? NULL
                ]);
              }

              // wiki items
              if(count($value['items'])) {
                $row->items()->delete();
                foreach($value['items'] as $key => $item) {
                  $wikiItem = $row->items()->create([
                        'title'     => $item['title'],
                        'body'      => $item['body'],
                        'order'     => $item['order']
                   ]);

                  if(isset($item['image_url'])) {
                    $wikiImage = Image::uploadImage($item['image_url'], 'wikiItem', $key);
                    $wikiItem->image()->delete();
                    $wikiItem->image()->create([
                        'image_url'       => $wikiImage,
                        'image_alt'       => $item['image_alt'] ?? NULL,
                        'image_title'     => $item['image_title'] ?? NULL,
                    ]);
                  }

                }
              }

              // wiki packages
              if(count($value['package_ids'])) {
                $row->packages()->delete();
                foreach($value['package_ids'] as $package_id) {
                   $row->packages()->create(['package_id' => $package_id]);
                }
              }


            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

}
