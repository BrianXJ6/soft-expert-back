<?php

namespace App\Repositories;

use PDO;
use PDOException;
use App\Models\Order;
use App\Dto\StoreOrderDto;
use App\Support\Repositories\BaseRepository;

class OrderRepository extends BaseRepository
{
    /**
     * Listing of orders
     *
     * @return array
     */
    public function list(): array
    {
        try {
            $stmt = $this->connection->prepare(<<<EOT
                SELECT
                    ord.id,
                    ord.total_without_tax,
                    ord.total_percentage,
                    ord.total_with_tax,
                    ord.total_products,
                    ord.created_at,
                    pdt.id as pdt_id,
                    pdt.name as pdt_name,
                    typ.type as pdt_type,
                    oap.qtd as pdt_qtd,
                    oap.tax as pdt_tax,
                    oap.total_without_tax as pdt_total_without_tax,
                    oap.total_percentage as pdt_total_percentage,
                    oap.total_with_tax as pdt_total_with_tax,
                    oap.unitary_value as pdt_unitary_value
                FROM orders as ord
                JOIN order_product as oap ON oap.order_id = ord.id
                JOIN products as pdt ON oap.product_id = pdt.id
                JOIN product_types as typ ON pdt.product_type_id = typ.id
            EOT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error when trying to list all orders in the database: " . $e->getMessage();
        }

        if (!is_array($result) || (is_array($result) && empty($result))) {
            return [];
        }

        $orders = [];
        foreach ($result as $item) {
            if (empty($orders[$item['id']])) {
                $orders[$item['id']] = [
                    'id' => $item['id'],
                    'total_without_tax' => $item['total_without_tax'],
                    'total_percentage' => $item['total_percentage'],
                    'total_with_tax' => $item['total_with_tax'],
                    'total_products' => $item['total_products'],
                    'created_at' => $item['created_at'],
                    'products' => [[
                        'id' => $item['pdt_id'],
                        'name' => $item['pdt_name'],
                        'type' => $item['pdt_type'],
                        'qtd' => $item['pdt_qtd'],
                        'tax' => $item['pdt_tax'],
                        'total_without_tax' => $item['pdt_total_without_tax'],
                        'total_percentage' => $item['pdt_total_percentage'],
                        'total_with_tax' => $item['pdt_total_with_tax'],
                        'unitary_value' => $item['pdt_unitary_value'],
                    ]]
                ];
            } else {
                $orders[$item['id']]['products'] = array_merge(
                    $orders[$item['id']]['products'],
                    [[
                        'id' => $item['pdt_id'],
                        'name' => $item['pdt_name'],
                        'type' => $item['pdt_type'],
                        'qtd' => $item['pdt_qtd'],
                        'tax' => $item['pdt_tax'],
                        'total_without_tax' => $item['pdt_total_without_tax'],
                        'total_percentage' => $item['pdt_total_percentage'],
                        'total_with_tax' => $item['pdt_total_with_tax'],
                        'unitary_value' => $item['pdt_unitary_value'],
                    ]]
                );
            }
        }

        return $orders;
    }

    /**
     * Script to insert new orders into the database
     *
     * @param \App\Dto\StoreOrderDto $data
     *
     * @return int
     */
    protected function halfStoreOrder(StoreOrderDto $data): int
    {
        $stmtOrder = $this->connection->prepare(<<<EOT
            INSERT INTO orders
                (total_without_tax, total_percentage, total_with_tax, total_products, created_at)
            VALUES
                (?, ?, ?, ?, ?)
        EOT);

        $stmtOrder->execute([
            $data->totalWithoutTax,
            $data->totalPercentage,
            $data->totalWithTax,
            $data->totalProducts,
            date('Y-m-d H:i:s')
        ]);

        return (int) $this->connection->lastInsertId();
    }

    /**
     * Script to insert new relationship pivots between order and products
     *
     * @param \App\Dto\StoreOrderDto $data
     * @param int $orderId
     *
     * @return void
     */
    protected function halfStoreOrderProduct(StoreOrderDto $data, int $orderId): void
    {
        $stmtProducts = $this->connection->prepare(<<<EOT
            INSERT INTO order_product
                (order_id, product_id, qtd, tax, total_without_tax, total_percentage, total_with_tax, unitary_value)
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?)
        EOT);

        /** @var \App\Dto\OrderProductPivotDto */
        foreach ($data->pivots as $pivot) {
            $stmtProducts->execute([
                $orderId,
                $pivot->productId,
                $pivot->qtd,
                $pivot->tax,
                $pivot->totalWithoutTax,
                $pivot->totalPercentage,
                $pivot->totalWithTax,
                $pivot->unitaryValue,
            ]);
        }
    }

    /**
     * Store a new order in database
     *
     * @param \App\Dto\StoreOrderDto $data
     *
     * @return \App\Models\Order
     */
    public function store(StoreOrderDto $data): Order
    {
        try {
            $this->connection->beginTransaction();
            $orderId = $this->halfStoreOrder($data);
            $this->halfStoreOrderProduct($data, $orderId);
            $this->connection->commit();
        } catch (PDOException $e) {
            $this->connection->rollBack();
            echo "Error when trying to insert a new order into the database: " . $e->getMessage();
        }

        $order = new Order();
        $order->id = $orderId;
        $order->totalWithoutTax = $data->totalWithoutTax;
        $order->totalPercentage = $data->totalPercentage;
        $order->totalWithTax = $data->totalWithTax;
        $order->totalProducts = $data->totalProducts;
        $order->createdAt = time();

        return $order;
    }
}
