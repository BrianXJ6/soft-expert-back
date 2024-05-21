<?php

namespace App\Dto;

use App\Support\Dto\BaseDto;

class ProductTypeDto extends BaseDto
{
    public int $id;
    public string $type;
    public float $tax;

    /**
     * Create a new ProductTypeDto instance
     *
     * @param int $id
     * @param string $type
     * @param float $tax
     */
    public function __construct(
        int $id,
        string $type,
        float $tax
    ) {
        $this->id = $id;
        $this->type = $type;
        $this->tax = $tax;
    }
}
