<?php

namespace ByJoby\Matching;

use ByJoby\Matching\Rankers\AmbivalentRanker;
use ByJoby\Matching\Rankers\RankerBuilder;
use ByJoby\Matching\Rankers\RankerInterface;

class Item
{
    protected $item, $ranker;

    public function __construct($item, $ranker = null)
    {
        $this->item = $item;
        if ($ranker) {
            $this->ranker = RankerBuilder::build($ranker);
        }
    }

    public function item()
    {
        return $this->item;
    }

    public function ranker(): RankerInterface
    {
        return $this->ranker ?? new AmbivalentRanker();
    }
}
