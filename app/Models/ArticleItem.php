<?php

namespace App\Models;

use App\Models\Imageable;
use Illuminate\Database\Eloquent\Model;

class ArticleItem extends Model
{
    protected $guarded = [];

    public function image() {
        return $this->morphOne(Imageable::class, 'imageable')
                    ->select('image_url', 'image_alt', 'image_title');
    }
}
