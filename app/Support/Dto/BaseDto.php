<?php

namespace App\Support\Dto;

use App\Support\Contracts\Arrayable;

abstract class BaseDto implements Arrayable
{
    /**
     * Get the instance as an array.
     *
     * @return array<TKey, TValue>
     */
    public function toArray(): array
    {
        return (array) $this;
    }
}
