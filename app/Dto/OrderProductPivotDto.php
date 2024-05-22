<?php

namespace App\Dto;

use App\Support\Dto\BaseDto;

class OrderProductPivotDto extends BaseDto
{
    public int $productId;
    public int $qtd;
    public float $tax;
    public float $totalWithoutTax;
    public float $totalPercentage;
    public float $totalWithTax;
    public float $unitaryValue;

    /**
     * Create a new OrderProductPivotDto instance
     *
     * @param int $productId
     * @param int $qtd
     * @param float $tax
     * @param float $totalWithoutTax
     * @param float $totalPercentage
     * @param float $totalWithTax
     * @param float $unitaryValue
     */
    public function __construct(
        int $productId,
        int $qtd,
        float $tax,
        float $totalWithoutTax,
        float $totalPercentage,
        float $totalWithTax,
        float $unitaryValue
    ) {
        $this->productId = $productId;
        $this->qtd = $qtd;
        $this->tax = $tax;
        $this->totalWithoutTax = $totalWithoutTax;
        $this->totalPercentage = $totalPercentage;
        $this->totalWithTax = $totalWithTax;
        $this->unitaryValue = $unitaryValue;
    }
}
