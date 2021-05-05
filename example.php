<?php

use ByJoby\Matching\Item;
use ByJoby\Matching\Matchers\StablePairMatcher;
use ByJoby\Matching\Pool;
use ByJoby\Matching\Rankers\ScoreRanker;

include 'vendor/autoload.php';

// men by default prefer women with short names
$men = new Pool();
$men->ranker(new ScoreRanker(function (Item $item) {
    return -strlen($item->item());
}));
$men->add('Alexander', ['Diana']);
$men->add('Brown');
$men->add('Carl');
$men->add('Dave');
$men->add('Ed');

// women by default prefer men with long names
$women = new Pool();
$women->ranker(new ScoreRanker(function (Item $item) {
    return strlen($item->item());
}));
$women->add('Ana', ['Dave']);
$women->add('Beatrice', ['Dave', 'Carl', 'Brown', 'Alexander']);
$women->add('Claire');
$women->add('Diana');
$women->add('Emily');

$matcher = new StablePairMatcher($men, $women);
$solution = $matcher->solve();
var_dump($solution);
var_dump($solution->array1to1());
