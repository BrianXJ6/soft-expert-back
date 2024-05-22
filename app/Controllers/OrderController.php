<?php

namespace App\Controllers;

use App\Services\OrderService;

class OrderController
{
    /**
     * Service class
     *
     * @var \App\Services\OrderService
     */
    private OrderService $service;

    /**
     * Create a new OrderController instance
     */
    public function __construct()
    {
        $this->service = new OrderService();
    }

    /**
     * Listing of orders
     *
     * @return void
     */
    public function list(): void
    {
        $response = $this->service->list();

        echo json_encode($response);
    }

    /**
     * Store a new order in database
     *
     * @return void
     */
    public function store(): void
    {
        $rawData = json_decode(file_get_contents('php://input'), true);
        $response = $this->service->store($rawData);

        echo json_encode($response);
    }
}
