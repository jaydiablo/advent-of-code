<?php

$list = range(0, 255);

$chars = str_split('34,88,2,222,254,93,150,0,199,255,39,32,137,136,1,167');

$lengths = array_map('ord', $chars);
$lengths = array_merge($lengths, [17, 31, 73, 47, 23]);

$rawPosition = 0;
$position = 0;
$skip = 0;

for ($i = 0; $i < 64; $i++) {
    foreach ($lengths as $length) {
        if (($position + $length) > count($list)) {
            // Have to do two slices
            $subset1 = array_slice($list, $position, count($list));
            $subset2 = array_slice($list, 0, $length - count($subset1));

            $subset = array_merge($subset1, $subset2);
            $subset = array_reverse($subset);

            $subset1 = array_slice($subset, 0, count($subset1));
            $subset2 = array_slice($subset, count($subset2) * -1);

            array_splice($list, $position, count($subset1), $subset1);
            array_splice($list, 0, count($subset2), $subset2);
        } else {
            $subset = array_slice($list, $position, $length);
            $subset = array_reverse($subset);

            array_splice($list, $position, $length, $subset);
        }

        $position += $length + $skip;
        $rawPosition += $length + $skip;

        if ($position >= count($list)) {
            $position = $position % (count($list));
        }

        $skip++;
    }
}

$dense = [];

foreach (array_chunk($list, 16) as $chunk) {
    $piece = null;

    array_walk($chunk, function ($sparse) use (&$piece) {
        if ($piece === null) {
            $piece = $sparse;
        }  else {
            $piece = $piece ^ $sparse;
        }
    });

    $dense[] = $piece;
}

$hash = '';

array_walk($dense, function ($step) use (&$hash) {
    $hash .= str_pad(dechex($step), 2, 0, STR_PAD_LEFT);
});

print $hash . PHP_EOL;
