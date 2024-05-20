<?php

namespace App\Dto;

use App\Support\Dto\BaseDto;

class ProductDto extends BaseDto
{
    public int $id;
    public string $name;
    public float $value;
    public string $type;
    public float $tax;

    /**
     * Create a new ProductDto instance
     *
     * @param int $id
     * @param string $name
     * @param float $value
     * @param string $type
     * @param float $tax
     */
    public function __construct(
        int $id,
        string $name,
        float $value,
        string $type,
        float $tax
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
        $this->type = $type;
        $this->tax = $tax;
    }
}
