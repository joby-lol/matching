<?php

namespace ByJoby\Matching\Rankers;

use ByJoby\Matching\Item;
use ByJoby\Matching\Pool;

/**
 * This ranker does basically nothing. It just returns the Pool items
 * in the order they appear in the Pool, and always returns a zero (equal)
 * value when comparing Items.
 */
class AmbivalentRanker implements RankerInterface
{
    public function compare(Item $a, Item $b): int
    {
        return 0;
    }

    public function rank(Pool $pool): array
    {
        return $pool->items();
    }
}
