<?php

namespace App\Models;

use App\Support\Models\BaseModel;

class Order extends BaseModel
{
    /**
     * Properties
     */
    private int $id;
    private float $totalWithoutTax;
    private float $totalPercentage;
    private float $totalWithTax;
    private int $totalProducts;
    private int $createdAt;

    /**
     * Get methods
     *
     * @param $property
     */
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        return null;
    }

    /**
     * Setter methods
     *
     * @param $property
     * @param $value
     */
    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

    /**
     * Get the instance as an array.
     *
     * @return array<TKey, TValue>
     */
    public function toArray(): array
    {
        $data = [];
        foreach (array_keys(get_class_vars(self::class)) as $key) {
            $data[$key] = $this->{$key};
        }

        return $data;
    }
}
