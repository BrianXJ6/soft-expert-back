<?php

namespace App\Repositories;

use PDO;
use PDOException;
use App\Dto\ProductTypeDto;
use App\Models\ProductType;
use App\Dto\StoreProductTypeDto;
use App\Support\Repositories\BaseRepository;

class ProductTypeRepository extends BaseRepository
{
    /**
     * Listing of types
     *
     * @return array
     *
     * @throws \PDOException
     */
    public function list(): array
    {
        try {
            $stmt = $this->connection->prepare("SELECT id, type, tax FROM product_types");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (is_array($result) && !empty($result)) {
                $collect = [];
                foreach ($result as $type) {
                    $collect[] = new ProductTypeDto(...array_values($type));
                }

                return $collect;
            }

            return [];
        } catch (PDOException $e) {
            echo "Error when trying to list all types in the database: " . $e->getMessage();
        }
    }

    /**
     * Show the a especific type by ID
     *
     * @param integer $id
     *
     * @return \App\Dto\ProductTypeDto|null
     *
     * @throws \PDOException
     */
    public function getById(int $id): ?ProductTypeDto
    {
        try {
            $stmt = $this->connection->prepare("SELECT id, type, tax FROM product_types WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($result)) {
                return null;
            }

            return new ProductTypeDto(...array_values($result[0]));
        } catch (PDOException $e) {
            echo "Error when trying to query a type by its ID: " . $e->getMessage();
        }
    }

    /**
     * Store a new type in database
     *
     * @param \App\Dto\StoreProductTypeDto $data
     *
     * @return \App\Models\ProductType
     */
    public function store(StoreProductTypeDto $data): ProductType
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO product_types (type, tax) VALUES (:type, :tax)");

            foreach (array_keys($data->toArray()) as $field) {
                $stmt->bindParam(":$field", $data->{$field});
            }

            $stmt->execute();

            $type = new ProductType(
                $this->connection->lastInsertId(),
                ...array_values($data->toArray())
            );
        } catch (PDOException $e) {
            echo "Error when trying to insert a new product type into the database: " . $e->getMessage();
        }

        return $type;
    }
}
