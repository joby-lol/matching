<?php
/* Matching Algorithms | https://github.com/jobyone/matching | MIT License */

namespace ByJoby\Matching\Matchers;

use ByJoby\Matching\Item;
use ByJoby\Matching\Pool;

class StablePairMatcher implements MatcherInterface
{
    protected $left, $right, $solution, $engagements;

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
        $this->engagements = [];
        $this->proposers = array_map(
            function (Item $item) {
                return [$item, $item->ranker()->rank($this->left)];
            },
            $this->right->items()
        );
        while ($unmatched = $this->unmatched()) {
            list($proposer, $preferences) = $unmatched;
            if ($preferences) {
                $this->propose($proposer, array_shift($preferences));
                array_push($this->proposers, [$proposer, $preferences]);
            }
        }
        $solution = new Solution();
        foreach ($this->engagements as $pair) {
            $solution->add($pair[1],$pair[0]);
        }
        return $solution;
    }

    protected function unmatched(): ?array
    {
        foreach ($this->proposers as $i => list($proposer,$preferences)) {
            if (!$this->isEngaged($proposer) && $preferences) {
                unset($this->proposers[$i]);
                return [$proposer,$preferences];
            }
        }
        return null;
    }

    protected function propose(Item $proposer, Item $proposee)
    {
        $current = $this->currentEngagement($proposee);
        if (!$current || $proposee->ranker()->compare($current, $proposer) > 0) {
            if ($current) {
                $this->breakEngagement($current, $proposee);
            }
            $this->makeEngagement($proposer, $proposee);
            return true;
        }
        return false;
    }

    protected function breakEngagement(Item $proposer, Item $proposee)
    {
        $this->engagements = array_filter(
            $this->engagements,
            function ($i) use ($proposer, $proposee) {
                return $i != [$proposer, $proposee];
            }
        );
    }

    protected function makeEngagement(Item $proposer, Item $proposee)
    {
        $this->engagements[] = [$proposer, $proposee];
    }

    protected function isEngaged(Item $item): bool
    {
        foreach ($this->engagements as $i) {
            if (in_array($item,$i)) {
                return true;
            }
        }
        return false;
    }

    protected function currentEngagement(Item $proposee): ?Item
    {
        foreach ($this->engagements as $pair) {
            if ($pair[1] == $proposee) {
                return $pair[0];
            }
        }
        return null;
    }
}
