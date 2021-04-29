<?php

namespace ByJoby\Matching;

use ByJoby\Matching\Rankers\AmbivalentRanker;
use ByJoby\Matching\Rankers\RankerBuilder;
use ByJoby\Matching\Rankers\RankerInterface;

class Item
{
    protected $pool, $item, $ranker;

    public function __construct(Pool $pool, $item, $ranker = null)
    {
        $this->pool = $pool;
        $this->item = $item;
        if ($ranker) {
            $this->ranker = RankerBuilder::build($ranker);
        }
    }

    public function item()
    {
        return $this->item;
    }

    public function pool(Pool $set = null): Pool
    {
        if ($set) {
            $this->pool = $set;
        }
        return $this->pool;
    }

    public function ranker(): RankerInterface
    {
        return $this->ranker ?? $this->pool->ranker() ?? new AmbivalentRanker();
    }
}
