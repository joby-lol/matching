<?php
/* Matching Algorithms | https://github.com/jobyone/matching | MIT License */

namespace ByJoby\Matching\Matchers;

use ByJoby\Matching\Item;
use ByJoby\Matching\Pool;

class DibsMatcher implements MatcherInterface
{
    protected $left, $right, $solution;

    public function __construct(Pool $left, Pool $right)
    {
        $this->left = $left;
        $this->right = $right;
    }

    public function solve(): Solution
    {
        if (!$this->solution) {
            $this->solution = $this->doSolve();
        }
        return $this->solution;
    }

    protected function doSolve(): Solution
    {
        $solution = new Solution();
        $options = clone $this->right;
        array_map(
            function (Item $dibber) use (&$options, &$solution) {
                $ranked = $dibber->ranker()->rank($options);
                if ($top = reset($ranked)) {
                    $options->remove($top);
                    $solution->add($dibber, $top);
                }
            },
            $this->left->items()
        );
        return $solution;
    }
}
