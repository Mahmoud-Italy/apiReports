<?php

namespace App\Models;

use Storage;
use Illuminate\Database\Eloquent\Model;

class Imageable extends Model
{
    protected $guarded = [];

    public function imageable() {
        return $this->morphTo();
    }

    public static function uploadImage($file)
    {
        $base64_str   = substr($file, strpos($file, ",")+1);
        $imageDecoded = base64_decode($base64_str);
        if(explode(';', $file)[0]) {
          $fileType   = explode(';', $file)[0];
          $fileType   = explode('/', $fileType)[1]; // png or jpg etc
          if ($fileType == 'svg+xml') {
                $fileType = 'svg';
          }
        }
        $fileName     = date('Y-m-d-h-i-s').'-'.uniqid().'.'.$fileType;
        Storage::disk('public')->put('uploads/'.$fileName, $imageDecoded);
        return $fileName;
    }

    public static function getImagePath($path, $image)
    {
        return request()->root().'/'.$path.'/'.$image;
    }

    public static function plural($singular = '')
    {
        if ( substr($singular, -1) == 'y') {
            return str_replace('y','ies',$singular);
        } else {
            return $singular.'s';
        }
    }
}
