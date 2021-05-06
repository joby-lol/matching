# Matching

A set of tools for setting up and running matching algorithms, such as solving stable matching problems.

Honestly this thing is barely started, and currently only has two matching algorithms available: A Gale-Shapley-esque stable pairing algorithm (`StablePairMatcher`), and one I call the `DibsMatcher` that simply lets one set of items call dibs on another set of items in a first-come first-serve manner.

## Example

```php
// first step is to establish a Pool of items
$men = new \ByJoby\Matching\Pool();
// the pool can have a ranking system to be used by default for its items
// in this case it uses the ScoreRanker to prefer women with long names
$men->ranker(
    new \ByJoby\Matching\ScoreRanker(function(\ByJoby\Ranker\Item $item) {
        return strlen($item->item());
    });
);
// next we assign the men to the pool
// items will be placed in Item objects automatically,
// and need not be strings
$men->add('Alexander');
$men->add('Bob');
$men->add('Carl');

// next we need another Pool to match with the first
// if no ranker is specified women will use the AmbivalentRanker, which
// effectively prefers the men in the order they appear in their Pool
$women = new \ByJoby\Matching\Pool();
// assign women to the pool the same way
$men->add('Andrea');
$men->add('Beatrice');
$men->add('Carla');

// pass the pools into a matcher object
// by convention if an algorithm favors the preferences of
// a particular pool, it should be left argument
$ranker = new \ByJoby\Matching\StablePairMatcher($women,$men);

// calling solve() on the ranker computes a Solution object
$solution = $ranker->solve();

// for 1-to-1 matchings like this, the array1to1() method will yield
// an array with the left side (women) as keys and right side as values
$array = $solution->array1to1();
```
