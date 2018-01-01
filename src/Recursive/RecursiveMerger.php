<?php
declare(strict_types=1);

namespace ExtendsFramework\Merger\Recursive;

use ExtendsFramework\Merger\MergerInterface;

class RecursiveMerger implements MergerInterface
{
    /**
     * When a key in the $right array does not exist in the $left array, it will be added to the $left array. The
     * $right value will always overwrite the $left value when one of both is not an array.
     *
     * When the values in the $right array and $left array are both arrays, the will be merged. If the value in the
     * $right array is associative, they will be merged recursively with this function. When the value in the $right
     * array is indexed, it will be merged (compare items normally) with the array from the $left array and values
     * will be unique.
     *
     * @inheritDoc
     */
    public function merge(array $left, array $right): array
    {
        foreach ($right as $key => $value) {
            if (is_array($value) === true && isset($left[$key]) === true && is_array($left[$key]) === true) {
                if ($this->isAssoc($value)) {
                    $left[$key] = $this->merge($left[$key], $value);
                } else {
                    $left[$key] = array_merge($left[$key], $value);
                    $left[$key] = array_unique($left[$key], SORT_REGULAR);
                }
            } else {
                $left[$key] = $value;
            }
        }

        return $left;
    }

    /**
     * Check if $array is an associative array.
     *
     * @param array $array
     * @return bool True when $value is an associative array, false otherwise.
     */
    protected function isAssoc(array $array): bool
    {
        return array_values($array) !== $array;
    }
}
