<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateCategory extends Model
{
    protected $guarded = [];

    public function image1() {
        return $this->morphOne(Imageable::class, 'imageable')
                      ->where('type', 0)
                      ->select('url');
    }
    public function image2() {
        return $this->morphOne(Imageable::class, 'imageable')
                      ->where('type', 1)
                      ->select('url');
    }
}
