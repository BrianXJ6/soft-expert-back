<?php

namespace App\Dto;

use App\Support\Dto\BaseDto;

class StoreProductTypeDto extends BaseDto
{
    public string $type;
    public float $tax;

    /**
     * Create a new StoreProductTypeDto instance
     *
     * @param string $type
     * @param float $tax
     */
    public function __construct(string $type, float $tax)
    {
        $this->type = $type;
        $this->tax = $tax;
    }
}
