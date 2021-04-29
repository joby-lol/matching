<?php

namespace ByJoby\Matching\Rankers;

class RankerBuilder
{
    static function build($ranker): RankerInterface
    {
        // return unchanged if it's already a ranker
        if ($ranker instanceof RankerInterface) {
            return $ranker;
        }
        // arrays used as ranker interface
        if (is_array($ranker)) {
            return new ArrayRanker($ranker);
        }
    }
}
