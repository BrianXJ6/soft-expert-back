<?php

namespace App\Services;

use App\Dto\StoreProductDto;
use App\Repositories\ProductRepository;

class ProductService
{
    /**
     * Repository class
     *
     * @var \App\Repositories\ProductRepository
     */
    protected ProductRepository $repository;

    /**
     * Create a new Product Service instance
     */
    public function __construct()
    {
        $this->repository = new ProductRepository();
    }

    /**
     * Listing of products
     *
     * @return array
     */
    public function list(): array
    {
        $result = $this->repository->list();

        return ['data' => $result];
    }

    /**
     * Show the a especific product by ID
     *
     * @param integer $id
     *
     * @return array
     */
    public function getById(int $id): array
    {
        $result = $this->repository->getById($id);

        return $result
            ? ['data' => $result->toArray()]
            : ['message' => 'Produto não encontrado!'];
    }

    /**
     * Store a new product in database
     *
     * @param \App\Dto\StoreProductDto $data
     *
     * @return array
     */
    public function store(StoreProductDto $data): array
    {
        $product = $this->repository->store($data);

        return ['data' => $product->toArray()];
    }
}
