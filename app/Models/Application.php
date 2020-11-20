<?php

namespace App\Models;

use DB;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $guarded = [];

    // Ferch Data
    public static function fetchData($value='')
    {
        // this way will fire up speed of the query
        $obj = self::query();

          // search for multiple columns..
          if(isset($value['search']) && $value['search']) {
            $obj->where(function($q) use ($value) {
                $q->Where('name', 'like', '%'.$value['search'].'%');
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
            $obj->orderBy('name', 'ASC');
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
              $row->name        = $value['name'] ?? NULL;
              $row->icon        = $value['icon'] ?? NULL;
              $row->setup       = $value['setup'] ?? false;
              $row->status      = $value['status'] ?? false;
              $row->save();

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public static function applications()
    {
        $apps[] = ['Accommodations', 'ti-home'];
        $apps[] = ['Articles', 'ti-pencil-alt'];
        $apps[] = ['Cabins', 'ti-harddrives'];
        $apps[] = ['Categories', 'ti-harddrives'];
        $apps[] = ['Caches', 'ti-wand'];
        $apps[] = ['Cruises', 'ti-gift'];
        $apps[] = ['CruiseTypes', 'ti-signal'];
        $apps[] = ['Destinations', 'ti-map-alt'];
        $apps[] = ['Domains', 'ti-world'];
        $apps[] = ['FAQs', 'ti-help-alt'];
        $apps[] = ['Hotels', 'ti-medall'];
        $apps[] = ['Icons', 'ti-github'];
        $apps[] = ['Inbox', 'ti-email'];
        $apps[] = ['Inquires', 'ti-bell'];
        $apps[] = ['IP Blockers', 'ti-lock'];
        $apps[] = ['Logs', 'ti-brush-alt'];
        $apps[] = ['Media', 'ti-cloud-up'];
        $apps[] = ['Packages', 'ti-package'];
        $apps[] = ['PackageTypes', 'ti-signal'];
        $apps[] = ['Pages', 'ti-files'];
        $apps[] = ['Regions', 'ti-map'];
        $apps[] = ['Reviews', 'ti-star'];
        $apps[] = ['Roles', 'ti-key'];
        $apps[] = ['Settings', 'ti-settings'];
        $apps[] = ['Sliders', 'ti-gallery'];
        $apps[] = ['Socials', 'ti-twitter'];
        $apps[] = ['Tags', 'ti-tag'];
        $apps[] = ['Tenants', 'ti-panel'];
        $apps[] = ['Updates', 'ti-zip'];
        $apps[] = ['Users', 'ti-user'];
        $apps[] = ['Wikis', 'ti-agenda'];
        $apps[] = ['Writers', 'ti-paint-roller'];
        return $apps;
    }


    public static function run($tenant_id)
    {
      $apps = self::applications();
      for ($i=0; $i < count($apps); $i++) { 
          $insert[] = [
                    'name'       => $apps[$i][0], 
                    'icon'       => $apps[$i][1],
                    'setup'      => true,
                    'status'     => true, 
                    'created_at' => Carbon::now(), 
                    'updated_At' => Carbon::now()
          ];
      }
      App::insert($insert);
    }

    public static function getRow($value='')
    {
      $row = self::where(['status' => true, 'trash' => false]);
        if(is_numeric($value)) {
           $row->where('id', $value);
        } else {
           $row->where('name', $value);
        }
      $row = $row->first();  
      return $row ?? NULL;
    }



    public static function hasAuthorityToTenant($app_name, $tenant_id)
    {
        $isRoot = auth()->guard('api')->user()->roles()->first()->name;
        if($isRoot == 'root') {
            $obj = true;
        } else {
            if($tenant_id > 0) {
              // search if that user has permission on any application name
              // get permission ids depend on app_id and check if he has access on it
              $role_id = auth()->guard('api')->user()->roles()->first()->id;
              $permission_name = 'view_'.strtolower($app_name);
              $permission = Permission::where('tenant_id', $tenant_id)->where('name',$permission_name)->first();
              if($permission) {
                if(DB::table('role_has_permissions')
                              ->where('permission_id', $permission->id)
                              ->where('role_id', $role_id)
                              ->count()) {
                    $obj = true;
                }
              }
            }
        }

        return $obj ?? false;
    }

}
