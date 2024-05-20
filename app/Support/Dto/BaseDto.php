<?php

namespace App\Support\Dto;

abstract class BaseDto
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
