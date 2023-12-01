<?php

function strpos_recursive($haystack, $needle, $offset = 0, &$results = []): array
{
    $offset = strpos($haystack, $needle, $offset);
    if($offset === false) {
        return $results;
    }

    $results[] = $offset;
    return strpos_recursive($haystack, $needle, ($offset + 1), $results);
}

$input = file_get_contents(__DIR__ . '/data.txt');
$rows = explode(PHP_EOL, $input);

$toIntMapping = ['one' => 1, 'two' => 2, 'three' => 3, 'four' => 4, 'five' => 5, 'six' => 6, 'seven' => 7, 'eight' => 8, 'nine' => 9];
$values = [1, 2, 3, 4, 5, 6, 7, 8, 9, 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];

$results = [];
foreach ($rows as $row) {
    
    $res = [];
    foreach ($values as $value) {
        foreach (strpos_recursive($row, $value) as $po) {
            $res[$po] = $toIntMapping[$value] ?? $value;
        }
    }

    if ($res) {
        ksort($res);
        $res = array_values($res);
        $results[] = $res[0] . $res[count($res) - 1];
    }
}

var_dump(array_sum($results));
