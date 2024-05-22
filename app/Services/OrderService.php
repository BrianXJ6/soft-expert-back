<?php

namespace App\Services;

use App\Dto\StoreOrderDto;
use App\Dto\OrderProductsDto;
use App\Dto\OrderProductPivotDto;
use App\Repositories\OrderRepository;

class OrderService
{
    /**
     * Repository class
     *
     * @var \App\Repositories\OrderRepository
     */
    protected OrderRepository $repository;

    /**
     * Create a new OrderService instance
     */
    public function __construct()
    {
        $this->repository = new OrderRepository();
    }

    /**
     * Listing of orders
     *
     * @return array
     */
    public function list(): array
    {
        $result = $this->repository->list();

        return ['data' => $result];
    }

    /**
     * Prepare the request to store order
     *
     * @param array $rawData
     *
     * @return array
     */
    public function prepareRequest(array $rawData): array
    {
        $collection = [];
        foreach ($rawData as $data) {
            $collection[] = new OrderProductsDto(...toExtract($data, OrderProductsDto::class));
        }

        return $collection;
    }

    /**
     * Prepare Order data to store in database
     *
     * @param array<\App\Dto\OrderProductsDto> $collection
     *
     * @return \App\Dto\StoreOrderDto
     */
    public function prepareOrderToStore(array $collection): StoreOrderDto
    {
        $orderProductCollection = [];
        $orderTotalWithoutTax = 0;
        $orderTotalPercentage = 0;
        $orderTotalWithTax = 0;
        $orderTotalProducts = 0;

        /** @var \App\Dto\OrderProductsDto */
        foreach ($collection as $orderProduct) {
            $orderTotalWithoutTax += $totalWithoutTax = ($orderProduct->value * $orderProduct->qtd);
            $orderTotalPercentage += $totalPercentage = ($totalWithoutTax / 100) * $orderProduct->tax;
            $orderTotalWithTax += $totalWithTax = $totalWithoutTax + $totalPercentage;
            $orderTotalProducts += $orderProduct->qtd;
            $orderProductCollection[] = new OrderProductPivotDto(
                $orderProduct->id,
                $orderProduct->qtd,
                $orderProduct->tax,
                $totalWithoutTax,
                $totalPercentage,
                $totalWithTax,
                $orderProduct->value
            );
        }

        return new StoreOrderDto(
            $orderTotalWithoutTax,
            $orderTotalPercentage,
            $orderTotalWithTax,
            $orderTotalProducts,
            $orderProductCollection
        );
    }

    /**
     * Store a new order in database
     *
     * @param array $rawData
     *
     * @return array
     */
    public function store(array $rawData): array
    {
        $orderDto = $this->prepareOrderToStore($this->prepareRequest($rawData));
        $order = $this->repository->store($orderDto);

        return ['data' => $order->toArray()];
    }
}
