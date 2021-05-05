<?php

namespace ByJoby\Matching\Rankers;

use ByJoby\Matching\Item;

class ScoreRanker extends AbstractRanker
{
    protected $scorer;

    public function __construct(callable $scorer)
    {
        $this->scorer = $scorer;
    }

    public function compare(Item $a, Item $b): int
    {
        $a = call_user_func($this->scorer,$a);
        $b = call_user_func($this->scorer,$b);
        if ($a === $b) {
            return 0;
        } else {
            return $a > $b ? -1 : 1;
        }
    }
}
