<?php
declare(strict_types=1);

namespace ExtendsFramework\Merger;

interface MergerInterface
{
    /**
     * Merge $right into $left.
     *
     * @param array $left
     * @param array $right
     * @return array
     * @throws MergerException
     */
    public function merge(array $left, array $right): array;
}
