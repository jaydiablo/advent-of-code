<?php

ini_set('memory_limit', -1);

$input = '370';

//$input = '3';

$buffer = [0];

$pos = 0;

$prev = 0;

for ($i = 1; $i <= 50000000; $i++) {
    $pos = (($pos + $input) % count($buffer));

    $buffer[] = 1;

    $pos = $pos + 1;

    // 0 is always at position 0
    if ($pos === 1) {
        print $i . PHP_EOL;
    }
}
