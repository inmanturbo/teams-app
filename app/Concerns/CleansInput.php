<?php

namespace App\Concerns;

trait CleansInput
{
    /**
     * Clean the input array.
     */
    protected function cleanInput(array $input): array
    {
        foreach ($input as &$value) {
            if (is_array($value)) {
                $value = $this->cleanInput($value);
            } elseif (is_string($value)) {
                $value = trim($value);
                if ($value === '') {
                    $value = null;
                }
            }
        }

        return $input;
    }
}
