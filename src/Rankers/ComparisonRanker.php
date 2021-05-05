<?php

namespace ByJoby\Matching\Rankers;

use ByJoby\Matching\Item;

class ComparisonRanker extends AbstractRanker
{
    protected $comparer;

    public function __construct(callable $comparer)
    {
        $this->comparer = $comparer;
    }

    public function compare(Item $a, Item $b): int
    {
        return call_user_func($this->comparer,$a,$b);
    }
}
