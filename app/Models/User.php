<?php

namespace App\Models;

use DB;
use App\Models\Image;
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

    public function image() {
        return $this->morphOne(Image::class, 'imageable');
    }

    public static function fetchData($value='')
    {
        $obj = self::whereNOTNULL('id');

            if(isset($value['roleName'])) {
                if($value['roleName'] == 'Account') {
                    $obj->getRoleNames()[0] == 'Member';
                } else if ($value['roleName'] == 'Staff') {
                    $obj->getRoleNames()[0] != 'Member';
                }
            }

            if(isset($value['search'])) {
                $obj->where(function($q){
                    $q->where('name', 'like','%'.$value['search'].'%');
                    $q->orWhere('email', 'like', '%'.$value['search'].'%');
                    $q->orWhere('mobile', $value['search']);
                    $q->orWhere('id', $value['search']);
                });
            }
            
            if(isset($value['order'])) {
                $obj->orderBy('id', $value['order']);
            } else {
                $obj->orderBy('id', 'DESC');
            }

        $obj = $obj->paginate($value['paginate'] ?? 10);
        return $obj;
    }
}
