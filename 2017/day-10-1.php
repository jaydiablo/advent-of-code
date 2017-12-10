<?php

$list = range(0, 255);
//$list = [0, 1, 2, 3, 4];

//$lengths = explode(',', '3,4,1,5');
$lengths = explode(',', '34,88,2,222,254,93,150,0,199,255,39,32,137,136,1,167');

$position = 0;
$skip = 0;

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

    if ($position >= count($list)) {
        $position = $position % (count($list));
    }

    $skip++;
}

print $list[0] * $list[1] . PHP_EOL;
