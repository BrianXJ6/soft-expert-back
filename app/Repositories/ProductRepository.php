<?php

namespace App\Repositories;

use PDO;
use PDOException;
use App\Dto\ProductDto;
use App\Models\Product;
use App\Dto\StoreProductDto;
use App\Support\Repositories\BaseRepository;

class ProductRepository extends BaseRepository
{
    /**
     * Listing of products
     *
     * @return array
     *
     * @throws \PDOException
     */
    public function list(): array
    {
        try {
            $stmt = $this->connection->prepare(<<<EOT
                SELECT
                    pdt.id, pdt.name, pdt.value,
                    typ.type, typ.tax
                FROM products as pdt
                JOIN product_types as typ ON pdt.product_type_id = typ.id
            EOT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (is_array($result) && !empty($result)) {
                $collect = [];
                foreach ($result as $product) {
                    $collect[] = new ProductDto(...array_values($product));
                }

                return $collect;
            }

            return [];
        } catch (PDOException $e) {
            echo "Error when trying to list all products in the database: " . $e->getMessage();
        }
    }

    /**
     * Show the a especific product by ID
     *
     * @param integer $id
     *
     * @return \App\Dto\ProductDto|null
     *
     * @throws \PDOException
     */
    public function getById(int $id): ?ProductDto
    {
        try {
            $stmt = $this->connection->prepare(<<<EOT
                SELECT
                    pdt.id, pdt.name, pdt.value,
                    typ.type, typ.tax
                FROM products as pdt
                JOIN product_types as typ ON pdt.product_type_id = typ.id
                WHERE pdt.id = :id
            EOT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($result)) {
                return null;
            }

            return new ProductDto(...array_values($result[0]));
        } catch (PDOException $e) {
            echo "Error when trying to query a product by its ID: " . $e->getMessage();
        }
    }

    /**
     * Store a new product in database
     *
     * @param \App\Dto\StoreProductDto $data
     *
     * @return \App\Models\Product
     */
    public function store(StoreProductDto $data): Product
    {
        try {
            $stmt = $this->connection->prepare(<<<EOT
                INSERT INTO products (name, value, product_type_id)
                VALUES (:name, :value, :product_type_id)
            EOT);

            foreach (array_keys($data->toArray()) as $field) {
                $stmt->bindParam(":$field", $data->{$field});
            }

            $stmt->execute();

            $product = new Product();
            $product->id = $this->connection->lastInsertId();
            foreach (array_keys($data->toArray()) as $key) {
                $product->$key = $data->{$key};
            }
        } catch (PDOException $e) {
            echo "Error when trying to insert a new product into the database: " . $e->getMessage();
        }

        return $product;
    }
}
