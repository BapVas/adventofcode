<?php

function getNumber(int $j, string $row): string
{
    $k = $j + 1;

    $number = $row[$j];
    while ($k < strlen($row) && is_numeric($row[$k])) {
        $number .= $row[$k];
        $k++;
    }

    return $number;
}

function getCharNearSymbolPos($arr, $x, $y): array|false
{
    if ($x < 0 || $x >= count($arr) || $y < 0 || $y >= strlen($arr[$x])) {
        return false;
    }

    $checkValue = static function($value): bool {
        return !in_array($value, ['', ' ', '.', null], true) && !is_numeric($value);
    };

    // Left
    if ($checkValue($arr[$x][$y - 1] ?? null)) {
        return [$x, $y - 1];
    }

    // Right
    if ($checkValue($arr[$x][$y + 1] ?? null)) {
        return [$x, $y + 1];
    }

    // Top
    if ($checkValue($arr[$x - 1][$y] ?? null)) {
        return [$x - 1, $y];
    }

    // Bottom
    if ($checkValue($arr[$x + 1][$y] ?? null)) {
        return [$x + 1, $y];
    }

    // Top Left
    if ($checkValue($arr[$x - 1][$y - 1] ?? null)) {
        return [$x - 1, $y - 1];
    }

    // Top Right
    if ($checkValue($arr[$x - 1][$y + 1] ?? null)) {
        return [$x - 1, $y + 1];
    }

    // Bottom Left
    if ($checkValue($arr[$x + 1][$y - 1] ?? null)) {
        return [$x + 1, $y - 1];
    }

    // Bottom Right
    if ($checkValue($arr[$x + 1][$y + 1] ?? null)) {
        return [$x + 1, $y + 1];
    }

    return [];
}

function getNumberAdjacentSymbolPos(string $number, array $rows, int $i, int $j): array|false
{
    for ($col = $j; $col <= $j + strlen($number) - 1; $col++) {
        $pos = getCharNearSymbolPos($rows, $i, $col);
        if ($pos) {
            return $pos;
        }
    }

    return false;
}

$input = file_get_contents(__DIR__ . '/data.txt');
$rows = explode(PHP_EOL, $input);
$totalRows = count($rows);
$res = [];

for ($i = 0; $i < $totalRows; $i++) {
    $totalLength = strlen($rows[$i]);
    for ($j = 0; $j < $totalLength; $j++) {
        $row = $rows[$i];

        if (is_numeric($row[$j])) {
            $number = getNumber($j, $row);

            $pos = getNumberAdjacentSymbolPos($number, $rows, $i, $j);
            if ($pos) {
                $res['x:' . $pos[0] . ' y:' . $pos[1]][] = $number;
            }

            $j += strlen($number); // Entier complet déjà récuperer donc on le saute
        }
    }
}

$res2 = [];
foreach ($res as $val) {
    if (count($val) > 1) {
        $res2[] = array_product($val);
    }
}

var_dump(array_sum($res2));