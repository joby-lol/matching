<?php

namespace ByJoby\Matching\Rankers;

use ByJoby\Matching\Item;

class ArrayRanker extends AbstractRanker
{
    protected $ranking = [];

    public function __construct(array $ranking)
    {
        $this->ranking = $ranking;
    }

    public function compare(Item $a, Item $b): int
    {
        $a = array_search($a->item(), $this->ranking);
        $b = array_search($b->item(), $this->ranking);
        if ($a === $b) {
            return 0;
        } elseif ($a === false) {
            return 1;
        } elseif ($b === false) {
            return -1;
        } else {
            return $a > $b ? -1 : 1;
        }
    }
}
