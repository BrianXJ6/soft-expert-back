<?php

if (!function_exists('toExtract')) {
    /**
     * Extract property data in sequence.
     *
     * @param array $post
     * @param string $class
     *
     * @return array
     */
    function toExtract(array $post, string $class): array
    {
        $data = [];
        foreach (array_keys(get_class_vars($class)) as $property) {
            if (array_key_exists($property, $post)) {
                $data[] = $post[$property];
            }
        }

        return $data;
    }
}
