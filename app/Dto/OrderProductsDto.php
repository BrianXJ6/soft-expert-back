<?php

namespace App\Dto;

use App\Support\Dto\BaseDto;

class OrderProductsDto extends BaseDto
{
    public int $id;
    public int $qtd;
    public float $value;
    public float $tax;

    /**
     * Create a new OrderProductsDto instance
     *
     * @param int $id
     * @param int $qtd
     * @param float $value
     * @param float $tax
     */
    public function __construct(
        int $id,
        int $qtd,
        float $value,
        float $tax
    ) {
        $this->id = $id;
        $this->qtd = $qtd;
        $this->value = $value;
        $this->tax = $tax;
    }
}
