<?php

$input = "seeds: 79 14 55 13

seed-to-soil map:
50 98 2
52 50 48

soil-to-fertilizer map:
0 15 37
37 52 2
39 0 15

fertilizer-to-water map:
49 53 8
0 11 42
42 0 7
57 7 4

water-to-light map:
88 18 7
18 25 70

light-to-temperature map:
45 77 23
81 45 19
68 64 13

temperature-to-humidity map:
0 69 1
1 0 69

humidity-to-location map:
60 56 37
56 93 4";

function getMappingEquivalentNumber(int $number, array $mappings): int
{
    foreach ($mappings as $mapping) {
        [$dest, $source, $length] = $mapping;
        if ($number >= $source && $number < $source + $length) {
            return $dest + ($number - $source);
        }
    }

    return $number;
}

$input = file_get_contents(__DIR__ . '/data.txt');
$rows = explode(PHP_EOL, $input);
$seeds = explode(' ', substr(trim($rows[0]), 7));
unset($rows[0]);
$mappingName = '';
$mappings = [];
$results = [];

foreach ($rows as $row) {
    if (trim($row) === "") {
        continue;
    }

    if (str_contains($row, 'map:')) {
        [$mappingName] = explode('map:', $row);
        $mappings[$mappingName] = [];
    } else {
        $mappings[$mappingName][] = explode(' ', trim($row));
    }
}

foreach ($seeds as $seed) {
    $currentNumber = $seed;
    foreach ($mappings as $mappingName => $mapping) {
        $currentNumber = getMappingEquivalentNumber($currentNumber, $mapping);
        if (!array_key_exists($seed, $results)) {
            $results[$seed] = [];
        }

        $results[$seed][$mappingName] = $currentNumber;
    }
}

function getMinSeedLocation(array $results)
{
    $min = PHP_INT_MAX;

    foreach ($results as $seed) {
        $location = end($seed);

        if ($location < $min) {
            $min = $location;
        }
    }

    return $min;
}

$min = getMinSeedLocation($results);

var_dump($min);