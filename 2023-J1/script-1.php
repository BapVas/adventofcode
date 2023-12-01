<?php

$input = file_get_contents(__DIR__ . '/data.txt');
$rows = explode(PHP_EOL, $input);

$results = [];
foreach ($rows as $row) {
    $row = preg_replace("/\D/", "", $row);
    $res = str_split($row);
    $results[] = $res[0] . $res[count($res) - 1];
}

var_dump(array_sum($results));
