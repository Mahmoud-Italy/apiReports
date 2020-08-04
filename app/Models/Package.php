<?php

namespace App\Models;

use DB;
use App\Models\User;
use App\Models\Domain;
use App\Models\Tenant;
use App\Models\Metable;
use App\Models\Category;
use App\Models\Taggable;
use App\Models\Imageable;
use App\Models\PackgeHotel;
use App\Models\Destination;
use App\Models\Accommodation;
use App\Models\PackageRelated;
use App\Models\PackgeItineraries;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $guarded = [];

    public function tenant() {
        return $this->belongsTo(Tenant::class, 'tenant_id')->where('tenant_id', Domain::getTenantId());
    }
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function destination() {
        return $this->belongsTo(Destination::class,'destination_id');
    }
    public function category() {
        return $this->belongsTo(Category::class,'category_id');
    }


    public function relateds() {
        return $this->hasMany(PackgeRelated::class, 'id');
    }
    public function hotels() {
        return $this->hasMany(PackgeHotel::class, 'id');
    }
    public function itineraries() {
        return $this->hasMany(PackgeItineraries::class, 'id');
    }
    public function hasDestinations() {
        return $this->hasMany(PackgeDestination::class, 'id');
    }
    public function accommodations(){
        return $this->hasMany(Accommodation::class,'package_id');
    }
    

    public function meta() {
        return $this->morphOne(Metable::class, 'metable')
                    ->select('meta_title', 'meta_keywords', 'meta_description');
    }
    public function image() {
        return $this->morphOne(Imageable::class, 'imageable')
                    ->where(['is_tiny' => false, 'is_gallery' => false, 'is_icon' => false])
                    ->select('image_url', 'image_alt', 'image_title');
    }
    public function image2() {
        return $this->morphOne(Imageable::class, 'imageable')
                    ->where(['is_tiny' => true, 'is_gallery' => false, 'is_icon' => false])
                    ->select('image_url', 'image_alt', 'image_title');
    }


    public function gallery() {
        return $this->morphMany(Imageable::class, 'imageable')
                    ->where('is_gallery', true)
                    ->select('image_url', 'image_alt', 'image_title');
    }
    public function icon() {
        return $this->morphMany(Imageable::class, 'imageable')
                    ->where('is_icon', true)
                    ->select('image_url', 'image_alt', 'image_title');
    }
    public function tags() {
        return $this->morphMany(Taggable::class, 'taggable');
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
              $row                     = (isset($id)) ? self::findOrFail($id) : new self;
              $row->tenant_id          = Domain::getTenantId();
              $row->user_id            = auth()->guard('api')->user()->id;
              $row->category_id        = $value['category_id'] ?? NULL;
              $row->destination_id     = $value['destination_id'] ?? NULL;
              $row->package_type_id    = $value['package_type_id'] ?? NULL;

              $row->slug               = $value['slug'] ?? NULL;
              $row->title              = $value['title'] ?? NULL;
              $row->short_title        = $value['short_title'] ?? NULL;
              $row->body               = $value['body'] ?? NULL;
              $row->short_body         = $value['short_body'] ?? NULL;
              $row->stars              = $value['stars'] ?? NULL;
              $row->star_num           = $value['star_num'] ?? NULL;
              $row->start_price        = $value['start_price'] ?? NULL;
              $row->popular            = $value['popular'] ?? NULL;
              $row->order              = $value['order'] ?? NULL;

              $row->included           = $value['included'] ?? NULL;
              $row->excluded           = $value['excluded'] ?? NULL;
              $row->duration           = $value['duration'] ?? NULL;
              $row->tour_type          = $value['tour_type'] ?? NULL;
              $row->visited_locations  = $value['visited_locations'] ?? NULL;

              $row->view_in_home       = $value['view_in_home'] ?? false;
              $row->view_in_destination_home = $value['view_in_destination_home'] ?? false;
              $row->is_combined_tour   = $value['is_combined_tour'] ?? false;
              $row->status             = $value['status'] ?? false;
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
                $image = Image::uploadImage($value['image_url'], 'package', 0, 'packages');
                $row->image()->delete();
                $row->image()->create([
                    'image_url'       => $image,
                    'image_alt'       => $value['image_alt'] ?? NULL,
                    'image_title'     => $value['image_title'] ?? NULL
                ]);
              }

              // image 2
              if(isset($value['image2_url'])) {
                $image2 = Image::uploadImage($value['image2_url'], 'package2', 0, 'packages');
                $row->image2()->delete();
                $row->image2()->create([
                    'image_url'       => $image2,
                    'image_alt'       => $value['image2_alt'] ?? NULL,
                    'image_title'     => $value['image2_title'] ?? NULL,
                    'is_tiny'         => true
                ]);
              }

              // gallery
              if(count($value['gallery'])) {
                $row->gallery()->delete();
                foreach ($value['gallery'] as $key => $gallery) {
                  $gallery_url = Image::uploadImage($value['gallery_url'], 'gallery', $key, 'packages');
                  $row->gallery()->create([
                      'image_url'       => $gallery_url,
                      'image_alt'       => $gallery['gallery_alt'] ?? NULL,
                      'image_title'     => $gallery['gallery_title'] ?? NULL,
                      'is_gallery'      => true
                  ]);
                }
              }

              // related id
              if(isset($value['related_ids'])) {
                $package->relateds()->delete();
                if($value['related_ids']) {
                  foreach ($value['related_ids'] as $related_id) {
                    $package->relateds()->create(['related_package_id' => $related_id]);
                  }
                }
              }


              // Relations with Hotels
              if(isset($value['hotel_ids'])) {
                  $package->hotels()->delete();
                  if($value['hotel_ids']) {
                      foreach ($value['hotel_ids'] as $hotel_id) {
                          $package->hotels()->create(['hotel_id' => $hotel_id]);
                      }
                  }
              }


              // icons
              if(count($value['icons'])) {
                $row->icon()->delete();
                foreach ($value['icons'] as $key => $icon) {
                  $icon_url = Image::uploadImage($value['icon_url'], 'icon', $key, 'packages');
                  $row->icon()->create([
                      'image_url'       => $icon_url,
                      'image_alt'       => $icon['icon_alt'] ?? NULL,
                      'image_title'     => $icon['icon_title'] ?? NULL,
                      'is_icon'         => true
                  ]);
                }
              }

              // Itienraries
              if(count($value['itineraries'])) {
                $row->itineraries()->delete();
                foreach ($value['itineraries'] as $key => $itinerary) {
                  $row->itineraries()->create([
                    'title'         => $itinerary['title'] ?? NULL,
                    'body'          => $itinerary['body'] ?? NULL,
                    'order'         => $itinerary['order'] ?? NULL,
                  ]);
                }
              }



              // Relations with accommodations
              if(isset($value['accommodations'])) {
                $package->accommodations()->delete();
                if($value['accommodations']) {
                    foreach ($value['accommodations'] as $accommodation) {
                    $accommo = $package->accommodations()->create(['name' =>$accommodation['name']]);
                        // accommodation hotels
                       foreach ($accommodation['hotels'] as $single_hotel) {
                           $accommoHotel = new AccommodationHotel;
                           $accommoHotel->accommodation_id = $accommo['id']; //ref
                           $accommoHotel->hotel_id = $single_hotel['id'];
                           $accommoHotel->save();
                       }
                        // accommodation prices
                        foreach ($accommodation['prices'] as $single_price) {
                            $accommoPrice = new AccommodationPrice;
                            $accommoPrice->accommodation_id = $accommo['id']; // ref
                            $accommoPrice->name = $single_price['name'];
                            $accommoPrice->save();

                            // price items
                            foreach ($single_price['items'] as $single_item) {
                                $accommoPriceItem = new AccommodationPriceItem;
                                $accommoPriceItem->accommodation_price_id = $accommoPrice['id'];
                                $accommoPriceItem->priceValue = $single_item['priceValue'];
                                $accommoPriceItem->description =$single_item['description'];
                                $accommoPriceItem->save();
                            }
                        }  

                    }
                }
              } // end of acommodations


              // Package Destination
              if(isset($value['package_destinations'])) {
                  $package->hasDestinations()->delete();
                  foreach ($value['package_destinations'] as $dest) {
                      $package->hasDestinations()->create(['destination_id'=>$dest]);
                  }
              }


              // tags
              if(isset($value['tags'])) {
                  $tagids = [];
                  for($i=0; $i < count($value['tags']); $i++) {
                      $tagids[] = Tag::getRow($value['tags'][$i])->id;
                  }
                  $package->tags()->delete();
                  foreach ($tagids as $tagid) {
                      $package->tags()->create(['tag_id'=>$tagid]);
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
