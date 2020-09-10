<?php

namespace App\Models;

use App\Models\Imageable;
use Illuminate\Database\Eloquent\Model;

class CertificateCategory extends Model
{
    protected $guarded = [];

    public function image() {
        return $this->morphOne(Imageable::class, 'imageable')
                      ->where('type', 0)
                      ->select('url');
    }
    public function pdf() {
        return $this->morphOne(Imageable::class, 'imageable')
                      ->where('type', 1)
                      ->select('url');
    }
}
