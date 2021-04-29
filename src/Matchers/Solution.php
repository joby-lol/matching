<?php

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
