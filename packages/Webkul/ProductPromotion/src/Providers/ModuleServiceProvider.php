<?php

namespace Webkul\ProductPromotion\Providers;

use Webkul\Core\Providers\CoreModuleServiceProvider;
use Webkul\ProductPromotion\Models\ProductPromotion;

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    protected $models = [
        ProductPromotion::class,
    ];
}
