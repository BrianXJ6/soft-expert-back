<?php

namespace App\Dto;

use App\Support\Dto\BaseDto;

class StoreProductDto extends BaseDto
{
    public int $product_type_id;
    public string $name;
    public float $value;

    /**
     * Create a new ProductDto instance
     *
     * @param int $product_type_id
     * @param string $name
     * @param float $value
     */
    public function __construct(
        string $product_type_id,
        string $name,
        float $value
    ) {
        $this->product_type_id = $product_type_id;
        $this->name = $name;
        $this->value = $value;
    }
}
