<?php

namespace App\Dto;

use App\Support\Dto\BaseDto;

class StoreOrderDto extends BaseDto
{
    public float $totalWithoutTax;
    public float $totalPercentage;
    public float $totalWithTax;
    public int $totalProducts;
    public array $pivots;

    /**
     * Create a new StoreOrderDto instance
     *
     * @param float $totalWithoutTax
     * @param float $totalPercentage
     * @param float $totalWithTax
     * @param int $totalProducts
     * @param array<\App\Dto\OrderProductPivotDto>
     */
    public function __construct(
        float $totalWithoutTax,
        float $totalPercentage,
        float $totalWithTax,
        int $totalProducts,
        array $pivots
    ) {
        $this->totalWithoutTax = $totalWithoutTax;
        $this->totalPercentage = $totalPercentage;
        $this->totalWithTax = $totalWithTax;
        $this->totalProducts = $totalProducts;
        $this->pivots = $pivots;
    }
}
