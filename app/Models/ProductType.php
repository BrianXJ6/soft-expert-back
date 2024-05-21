<?php

namespace App\Models;

use App\Support\Models\BaseModel;

class ProductType extends BaseModel
{
    /**
     * Properties
     */
    private ?int $id = null;
    private ?string $type;
    private ?float $tax;

    /**
     * Create a new ProductType instance
     *
     * @param integer|null $id
     * @param string|null $type
     * @param float|null $tax
     */
    public function __construct(
        ?int $id = null,
        ?string $type = null,
        ?float $tax = null
    ) {
        $this->id = $id;
        $this->type = $type;
        $this->tax = $tax;
    }

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
