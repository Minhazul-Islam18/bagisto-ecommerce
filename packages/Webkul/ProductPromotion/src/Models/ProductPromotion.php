<?php

namespace Webkul\ProductPromotion\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\ProductPromotion\Contracts\ProductPromotion as ProductPromotionContract;

class ProductPromotion extends Model implements ProductPromotionContract
{
    protected $table = 'product_promotions';

    protected $fillable = [
        'title',
        'banner',
        'starts_from',
        'ends_till',
        'status',
        'products',
    ];

    protected $casts = [
        'products' => 'json',
        'starts_from' => 'date',
        'ends_till' => 'date',
        'status' => 'boolean',
    ];
}
