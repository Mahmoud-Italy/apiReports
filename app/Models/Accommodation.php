<?php

namespace App\Models;

use DB;
use Str;
use App\Models\Tag;
use App\Models\User;
use App\Models\Domain;
use App\Models\Tenant;
use App\Models\Metable;
use App\Models\Imageable;
use App\Models\AccommodationHotel;
use App\Models\AccommodationPrice;
use App\Models\AccommodationPriceItem;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    protected $guarded = [];

    public function tenant() {
        return $this->belongsTo(Tenant::class, 'tenant_id')->where('tenant_id', Domain::getTenantId());
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hotels() {
        return $this->hasMany(AccommodationHotel::class, 'accommodation_id');
    }

    public function price() {
        return $this->hasMany(AccommodationPrice::class, 'accommodation_id');
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
          if(isset($value['search']) && $value['search']) {
            $obj->where(function($q) use ($value) {
                $q->where('name', 'like', '%'.$value['search'].'%');
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
              $row              = (isset($id)) ? self::findOrFail($id) : new self;
              $row->tenant_id   = Domain::getTenantId();
              //$row->user_id     = auth()->guard('api')->user()->id;
              $row->name        = $value['name'] ?? NULL;
              //$row->status      = $value['status'] ?? false;
              $row->save();

              // Hotels


              // Prices
              if(isset($value['prices']) && count($value['prices'])) {
                $row->price()->delete();

                foreach ($value['prices'] as $val) {
                  $price = $row->price()->create([
                      'name' => $val['price_name']
                  ]); 

                  // Price Items
                  if(isset($val['items']) && count($val['items'])) {
                    $price->items()->delete();
                    foreach ($val['items'] as $itm) {
                      $price->items()->create([
                          'price_value' => $itm['item_value'],
                          'body'        => $itm['item_body']
                      ]); 
                    }
                  }
                  // end Price items
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
