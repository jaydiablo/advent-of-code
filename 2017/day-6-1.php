<?php

$input = '2 8 8 5 4 2 3 1 5 5 1 2 15 13 5 14';

$banks = explode(' ', $input);

$redistributions = [];
$redistributions[implode('-', $banks)] = 1;

$i = 0;

function moveStart($start, $count) {
    $start++;

    if ($start === $count) {
        $start = 0;
    }

    return $start;
}

while (true) {
    $max = max($banks);
    $start = array_search($max, $banks);

    $newBanks = $banks;

    $newBanks[$start] = 0;
    $start = moveStart($start, count($banks));

    for ($j = 0; $j < $max; $j++) {
        $newBanks[$start]++;
        $start = moveStart($start, count($banks));
    }

    $banks = $newBanks;

    $i++;

    if (isset($redistributions[implode('-', $banks)])) {
        break;
    }

    $redistributions[implode('-', $banks)] = 1;
}

print $i . PHP_EOL;
