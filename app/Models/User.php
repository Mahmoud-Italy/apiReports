<?php

namespace App\Models;

use DB;
use App\Models\User;
use App\Models\Domain;
use App\Models\Tenant;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;

class User extends Model implements JWTSubject, AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }


    public function tenant() {
        return $this->belongsTo(Tenant::class, 'tenant_id')->where('tenant_id', Domain::getTenantId());
    }

    public function image() {
        return $this->morphOne(Imageable::class, 'imageable');
    }

    public static function fetchData($value='')
    {
        // this way will fire up speed of the query
        $obj = self::query();

            // get only his tenants
            $obj->has('tenant');

            if(isset($value['roleName']) && $value['roleName']) {
                if($value['roleName'] == 'Account') {
                    $obj->getRoleNames()[0] == 'Member';
                } else if ($value['roleName'] == 'Staff') {
                    $obj->getRoleNames()[0] != 'Member';
                }
            }

            if(isset($value['search']) && $value['search']) {
                $obj->where(function($q){
                    $q->where('name', 'like','%'.$value['search'].'%');
                    $q->orWhere('email', 'like', '%'.$value['search'].'%');
                    $q->orWhere('mobile', $value['search']);
                    $q->orWhere('id', $value['search']);
                });
            }
            
            if(isset($value['order']) && $value['order']) {
                $obj->orderBy('id', $value['order']);
            } else {
                $obj->orderBy('id', 'DESC');
            }

        $obj = $obj->paginate($value['paginate'] ?? 10);
        return $obj;
    }


    public static function createOrUpdate($id, $value)
    {
        try {
            
            DB::beginTransaction();

              // Row
              $row                 = (isset($id)) ? self::findOrFail($id) : new self;
              $row->tenant_id      = Domain::getTenantId();
              $row->name           = $value['name'] ?? NULL;
              $row->email          = $value['email'] ?? NULL;

              if(isset($value['password']) && $value['password']) {
                  $plainPassword   = $value['password'];
                  $row->password   = app('hash')->make($plainPassword);
              }

              $row->status         = $value['status'] ?? false;
              $row->save();

              // role
              $row->assignRole($value['role']); // assign role

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
