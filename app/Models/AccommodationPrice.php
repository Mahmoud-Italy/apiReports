<?php

namespace App\Models;

use App\Models\AccommodationPriceItem;
use Illuminate\Database\Eloquent\Model;

class AccommodationPrice extends Model
{
    protected $guarded = [];

    public function items() {
        return $this->hasMany(AccommodationPriceItem::class, 'accommodation_price_id');
    }
}
