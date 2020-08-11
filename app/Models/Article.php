<?php

namespace App\Models;

use DB;
use Str;
use App\Models\User;
use App\Models\Domain;
use App\Models\Tenant;
use App\Models\Writer;
use App\Models\Metable;
use App\Models\Category;
use App\Models\Imageable;
use App\Models\Destination;
use App\Models\ArticleItem;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
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
    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function writer() {
        return $this->belongsTo(Writer::class, 'writer_id');
    }

    public function meta() {
        return $this->morphOne(Metable::class, 'metable')
                    ->select('meta_title', 'meta_keywords', 'meta_description');
    }
    public function image() {
        return $this->morphOne(Imageable::class, 'imageable')
                    ->select('image_url', 'image_alt', 'image_title');
    }


    public function items() {
        return $this->hasMany(ArticleItem::class, 'article_id');
    }



    // fetch Data
    public static function fetchData($value='')
    {
        // this way will fire up speed of the query
        $obj = self::query();

          // get only his tenants
          $obj->has('tenant');

          // search for multiple columns..
          if(isset($value['search']) && $value['search']) {
            $obj->where(function($q) use ($value) {
                $q->where('slug', 'like', '%'.$value['search'].'%');
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
              $row                  = (isset($id)) ? self::findOrFail($id) : new self;
              $row->tenant_id       = Domain::getTenantId();
              //$row->user_id         = auth()->guard('api')->user()->id;
              $row->writer_id       = (int)$value['writer_id'] ?? NULL;
              //$row->destination_id  = (int)$value['destination_id'] ?? NULL;
              //$row->category_id     = (int)$value['category_id'] ?? NULL;
              $row->slug            = $value['slug'] ?? NULL;
              $row->title           = $value['title'] ?? NULL;
              $row->body            = $value['body'] ?? NULL;
              $row->short_body      = $value['short_body'] ?? NULL;
              $row->featured        = (boolean)$value['featured'] ?? false;
              $row->status          = (boolean)$value['status'] ?? false;
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
                if($value['image_url'] 
                  && !Str::contains($value['image_url'], ['s3.eu-central-1.amazonaws.com'])) {
                    $image = Imageable::uploadImage($value['image_url'], 'blog');
                } else {
                    $image = $value['image_url'];
                }
                $row->image()->delete();
                $row->image()->create([
                    'image_url'       => $image ?? NULL,
                    'image_alt'       => $value['image_alt'] ?? NULL,
                    'image_title'     => $value['image_title'] ?? NULL
                ]);
              }

              // items
              if(isset($value['items']) && count($value['items'])) {
                $row->items()->delete();
                foreach($value['items'] as $key => $item) {
                  $items = $row->items()->create([
                        'link'      => $item['link'] ?? NULL,
                        'content'   => $item['body'] ?? NULL,
                       // 'order'     => $item['order'] ?? NULL
                   ]);

                  if(isset($item['image_url'])) {
                    if($item['image_url'] 
                      && !Str::contains($item['image_url'], ['s3.eu-central-1.amazonaws.com'])) {
                        $itemImage = Imageable::uploadImage($item['image_url'], 'blog', $key);
                    } else {
                        $itemImage = $item['image_url'];
                    }
                    $items->image()->delete();
                    $items->image()->create([
                        'image_url'       => $itemImage,
                        'image_alt'       => $item['image_alt'] ?? NULL,
                        'image_title'     => $item['image_title'] ?? NULL,
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

}
