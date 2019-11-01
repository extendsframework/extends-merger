<?php
declare(strict_types=1);

namespace ExtendsFramework\Merger\Recursive;

use PHPUnit\Framework\TestCase;
use stdClass;

class RecursiveMergerTest extends TestCase
{
    /**
     * Merge.
     *
     * Test that two configs ($left and $right) can be merged and merged config ($merged) will be returned.
     *
     * @covers \ExtendsFramework\Merger\Recursive\RecursiveMerger::merge()
     */
    public function testMerge(): void
    {
        $left = [
            1,
            'a' => 'a',
            'b' => 1,
            'c' => null,
            'd' => [
                'a',
                'b',
                new stdClass(),
            ],
            'e' => null,
            'f',
            static function () {
                echo 'foo';
            },
            'x' => [
                'y' => 'z',
            ],
        ];

        $right = [
            2,
            'a' => null,
            'b' => [
                'a',
                'b',
            ],
            'c' => 'd',
            'd' => [
                'b',
                'c',
                new stdClass(),
            ],
            3,
            'g' => [
                'a',
                'b',
            ],
            static function () {
                echo 'bar';
            },
            'x' => [
                'z' => 'y',
            ],
        ];

        $expected = [
            0 => 2,
            'a' => null,
            'b' => [
                0 => 'a',
                1 => 'b',
            ],
            'c' => 'd',
            'd' => [
                0 => 'a',
                1 => 'b',
                2 => new stdClass(),
                4 => 'c',
            ],
            'e' => null,
            1 => 3,
            'g' => [
                0 => 'a',
                1 => 'b',
            ],
            2 => static function () {
                echo 'bar';
            },
            'x' => [
                'y' => 'z',
                'z' => 'y',
            ],
        ];

        $merger = new RecursiveMerger();
        $merged = $merger->merge($left, $right);

        $this->assertEquals($expected, $merged);
    }
}
