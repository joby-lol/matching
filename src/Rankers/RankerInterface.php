<?php

namespace ByJoby\Matching\Rankers;

use ByJoby\Matching\Item;
use ByJoby\Matching\Pool;

interface RankerInterface
{
    /**
     * Compare two items and return an integer indicating their relative
     * rank. Output should work the same as user sorting functions, where:
     * -1 indicates $a > $b
     *  0 indicates $a == $b
     *  1 indicates $a < $b
     *
     * Any positive or negative integer is valid output in place of -1
     * or 1.
     * 
     * @param Item $a
     * @param Item $b
     * @return integer
     */
    public function compare(Item $a, Item $b): int;

    /**
     * Sort the items of a given Pool using this ranker's compare method.
     *
     * @param Pool $pool
     * @return array
     */
    public function rank(Pool $pool): array;
}
