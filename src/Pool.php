<?php

namespace ByJoby\Matching;

use ByJoby\Matching\Rankers\AmbivalentRanker;
use ByJoby\Matching\Rankers\RankerBuilder;
use ByJoby\Matching\Rankers\RankerInterface;

class Pool
{
    protected $ranker;
    protected $items = [];

    public function __construct(array $items = [])
    {
        array_map([$this, 'add'], $items);
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function items(): array
    {
        return $this->items;
    }

    /**
     * When cloning we need to also clone all items and set their pool
     * to this new cloned object
     *
     * @return void
     */
    public function __clone()
    {
        $this->items = array_map(
            function (Item $item) {
                $item = clone $item;
                $item->pool($this);
                return $item;
            },
            $this->items
        );
    }

    public function ranker($set = null): RankerInterface
    {
        if ($set) {
            $this->ranker = RankerBuilder::build($set);
        }
        return $this->ranker ?? new AmbivalentRanker();
    }

    public function add($item, $ranker = null)
    {
        if ($item instanceof Item) {
            $item = $item->item();
        }
        if ($this->contains($item)) {
            return;
        }
        $this->items[] = new Item($this, $item, $ranker);
    }

    public function remove($item, $ranker = null)
    {
        if ($item instanceof Item) {
            $item = $item->item();
        }
        $this->items = array_filter(
            $this->items,
            function (Item $i) use ($item) {
                return $i->item() != $item;
            }
        );
    }

    public function contains($item)
    {
        foreach ($this->items as $i) {
            if ($i->item() == $item) {
                return true;
            }
        }
        return false;
    }
}
