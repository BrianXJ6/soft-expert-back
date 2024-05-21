<?php

namespace App\Services;

use App\Dto\StoreProductTypeDto;
use App\Repositories\ProductTypeRepository;

class ProductTypeService
{
    /**
     * Repository class
     *
     * @var \App\Repositories\ProductTypeRepository
     */
    protected ProductTypeRepository $repository;

    /**
     * Create a new ProductTypeService instance
     */
    public function __construct()
    {
        $this->repository = new ProductTypeRepository();
    }

    /**
     * Listing of types
     *
     * @return array
     */
    public function list(): array
    {
        $result = $this->repository->list();

        return ['data' => $result];
    }

    /**
     * Show the a especific type by ID
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
            : ['message' => 'Tipo de produto não encontrado!'];
    }

    /**
     * Store a new type in database
     *
     * @param \App\Dto\StoreProductTypeDto $data
     *
     * @return array
     */
    public function store(StoreProductTypeDto $data): array
    {
        $type = $this->repository->store($data);

        return ['data' => $type->toArray()];
    }
}
