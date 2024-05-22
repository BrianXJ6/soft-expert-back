<?php

namespace App\Controllers;

use App\Dto\StoreProductTypeDto;
use App\Services\ProductTypeService;

class ProductTypeController
{
    /**
     * Product service
     *
     * @var \App\Services\ProductTypeService
     */
    private ProductTypeService $service;

    /**
     * Create a new ProductTypeController instance
     */
    public function __construct()
    {
        $this->service = new ProductTypeService();
    }

    /**
     * Listing of types
     *
     * @return void
     */
    public function list(): void
    {
        $response = $this->service->list();

        echo json_encode($response);
    }

    /**
     * Show the a especific type by ID
     *
     * @param integer $id
     *
     * @return void
     */
    public function show(int $id): void
    {
        $response = $this->service->getById($id);

        echo json_encode($response);
    }

    /**
     * Store a new type in database
     *
     * @return void
     */
    public function store(): void
    {
        $rawData = json_decode(file_get_contents('php://input'), true);
        $storeProductType = new StoreProductTypeDto(...toExtract($rawData, StoreProductTypeDto::class));
        $response = $this->service->store($storeProductType);

        echo json_encode($response);
    }
}
