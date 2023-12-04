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

function isCharNearSymbol($arr, $x, $y): bool
{
    if ($x < 0 || $x >= count($arr) || $y < 0 || $y >= strlen($arr[$x])) {
        return false;
    }

    $checkValue = static function($value): bool {
        return !in_array($value, ['', ' ', '.', null], true) && !is_numeric($value);
    };

    // Left
    if ($checkValue($arr[$x][$y - 1] ?? null)) {
        return true;
    }

    // Right
    if ($checkValue($arr[$x][$y + 1] ?? null)) {
        return true;
    }

    // Top
    if ($checkValue($arr[$x - 1][$y] ?? null)) {
        return true;
    }

    // Bottom
    if ($checkValue($arr[$x + 1][$y] ?? null)) {
        return true;
    }

    // Top Left
    if ($checkValue($arr[$x - 1][$y - 1] ?? null)) {
        return true;
    }

    // Top Right
    if ($checkValue($arr[$x - 1][$y + 1] ?? null)) {
        return true;
    }

    // Bottom Left
    if ($checkValue($arr[$x + 1][$y - 1] ?? null)) {
        return true;
    }

    // Bottom Right
    if ($checkValue($arr[$x + 1][$y + 1] ?? null)) {
        return true;
    }

    return false;
}

function isNumberAdjacentToSymbol(string $number, array $rows, int $i, int $j): bool
{
    for ($col = $j; $col <= $j + strlen($number) - 1; $col++) {
        if (isCharNearSymbol($rows, $i, $col)) {
            return true;
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

            if (isNumberAdjacentToSymbol($number, $rows, $i, $j)) {
                $res[] = $number;
            }

            $j += strlen($number); // Entier complet déjà récuperer donc on le saute
        }
    }
}

var_dump(array_sum($res));