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

    public static function uploadFile($file, $name, $key=0)
    {
        $base64_str   = substr($imagePath, strpos($imagePath, ",")+1);
        $imageDecoded = base64_decode($base64_str);
        if(explode(';', $imagePath)[0]) {
          $type       = explode(';', $imagePath)[0];
          $type       = explode('/', $type)[1]; // png or jpg etc
          if ($type == 'svg+xml') {
            $type='svg';
          }
        }

        $time         = $name.time().$key.uniqid();
        $imageName    = $time.'.'.$type;
        // AWS 
        Storage::disk('s3')->put('multitenacy/'.$this->plural($name).'/'.$imageName, $imageDecoded);

        return $path.$fileName;
    }

    public static function getImagePath($path, $image)
    {
        return 'https://s3.eu-central-1.amazonaws.com/other.projects.storage/multitenacy/'.$path.'/'.$image;
    }

    public function plural($singular = '')
    {
        if ( substr($singular, -1) == 'y') {
            return str_replace('y','ies',$singular);
        } else {
            return $singular.'s';
        }
    }
}
