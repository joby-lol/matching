<?php
/* Matching Algorithms | https://github.com/jobyone/matching | MIT License */

namespace ByJoby\Matching\Matchers;

use ByJoby\Matching\Pool;

interface MatcherInterface
{
    public function __construct(Pool $left, Pool $right);
    public function solve(): Solution;
}
