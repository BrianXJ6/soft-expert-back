<?php

namespace App\Controllers;

use App\Dto\StoreProductDto;
use App\Services\ProductService;

class ProductController
{
    /**
     * Product service
     *
     * @var \App\Services\ProductService
     */
    private ProductService $service;

    /**
     * Create a new ProductController instance
     */
    public function __construct()
    {
        $this->service = new ProductService();
    }

    /**
     * Listing of products
     *
     * @return void
     */
    public function list(): void
    {
        $response = $this->service->list();

        echo json_encode($response);
    }

    /**
     * Show the a especific product by ID
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
     * Store a new product in database
     *
     * @return void
     */
    public function store(): void
    {
        $rawData = json_decode(file_get_contents('php://input'), true);
        $storeProduct = new StoreProductDto(...toExtract($rawData, StoreProductDto::class));
        $response = $this->service->store($storeProduct);

        echo json_encode($response);
    }
}
