<?php

use ByJoby\Matching\Matchers\DibsMatcher;
use ByJoby\Matching\Matchers\Marriage;
use ByJoby\Matching\Pool;

include 'vendor/autoload.php';

$men = new Pool();
$men->add('Adam', ['Beatrice']);
$men->add('Bob', ['Beatrice', 'Diana']);
$men->add('Carl');
$men->add('Dave');

$women = new Pool();
$women->add('Ana');
$women->add('Beatrice');
$women->add('Claire');
$women->add('Diana');

$matcher = new DibsMatcher($men, $women);
var_dump($matcher->solve());
