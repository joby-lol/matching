<?php
/* Matching Algorithms | https://github.com/jobyone/matching | MIT License */

namespace ByJoby\Matching\Matchers;

use ByJoby\Matching\Item;

class Solution
{
    protected $pairs = [];

    public function add(Item $left, Item $right)
    {
        $left = $this->normalizeItem($left);
        $right = $this->normalizeItem($right);
        $this->pairs[] = [$left, $right];
        $this->pairs = array_unique($this->pairs, SORT_REGULAR);
    }

    public function array1toN(): array
    {
        $out = [];
        foreach ($this->lefts() as $left) {
            $out[$left] = $this->rights($left);
        }
        return $out;
    }

    public function array1to1(): array
    {
        return array_map(
            function ($val) {
                if ($val) {
                    return reset($val);
                }else {
                    return null;
                }
            },
            $this->array1toN()
        );
    }

    public function contains($left, $right)
    {
        $left = $this->normalizeItem($left);
        $right = $this->normalizeItem($right);
        return array_search([$left, $right], $this->pairs) !== false;
    }

    public function pairs(): array
    {
        return $this->pairs;
    }

    public function lefts($right = null): array
    {
        if ($right) {
            return array_unique(array_filter(array_map(
                function ($item) use ($right) {
                    return $item[1] == $right ? $item[0] : false;
                },
                $this->pairs
            )));
        } else {
            return array_unique(array_map(
                function ($item) {
                    return $item[0];
                },
                $this->pairs
            ));
        }
    }

    public function rights($left = null): array
    {
        if ($left) {
            return array_unique(array_filter(array_map(
                function ($item) use ($left) {
                    return $item[0] == $left ? $item[1] : false;
                },
                $this->pairs
            )));
        } else {
            return array_unique(array_map(
                function ($item) {
                    return $item[1];
                },
                $this->pairs
            ));
        }
    }

    public function remove(Item $left, Item $right)
    {
        $left = $this->normalizeItem($left);
        $right = $this->normalizeItem($right);
        $this->pairs = array_filter(
            $this->pairs,
            function ($pair) use ($left, $right) {
                return $pair != [$left, $right];
            }
        );
    }

    protected function normalizeItem($item)
    {
        if ($item instanceof Item) {
            return $item->item();
        } else {
            return $item;
        }
    }
}
