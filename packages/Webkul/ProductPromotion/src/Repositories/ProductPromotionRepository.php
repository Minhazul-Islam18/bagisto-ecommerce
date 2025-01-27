<?php

namespace Webkul\ProductPromotion\Repositories;

use Illuminate\Container\Container;
use Webkul\Core\Eloquent\Repository;
use Webkul\ProductPromotion\Models\ProductPromotion;

class ProductPromotionRepository extends Repository
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    public function model(): string
    {
        return ProductPromotion::class;
    }

    public function create(array $data)
    {
        $data = $this->transformFormData($data);

        return parent::create($data);
    }

    public function update(array $data, $id)
    {
        $data = $this->transformFormData($data);

        return parent::update($data, $id);
    }

    public function transformFormData(array $data): array
    {
        return [
            ...$data,
            'products' => json_encode($data['products'] ?? []),
            'starts_from' => !empty($data['starts_from']) ? $data['starts_from'] : null,
            'ends_till' => !empty($data['ends_till']) ? $data['ends_till'] : null,
            'status' => isset($data['status']),
        ];
    }
}
