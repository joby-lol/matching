<?php
/* Matching Algorithms | https://github.com/jobyone/matching | MIT License */

namespace ByJoby\Matching\Rankers;

use ByJoby\Matching\Pool;

abstract class AbstractRanker implements RankerInterface
{
    public function rank(Pool $pool): array
    {
        $items = $pool->items();
        usort(
            $items,
            [$this, 'compare']
        );
        return $items;
    }
}