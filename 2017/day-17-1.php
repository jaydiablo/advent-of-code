<?php

$input = '370';

//$input = '3';

$buffer = [0];

$pos = 0;

for ($i = 1; $i <= 2017; $i++) {
    $pos = (($pos + $input) % count($buffer));

    array_splice($buffer, $pos + 1, 0, $i);

    $pos = $pos + 1;
}

print $buffer[array_search('2017', $buffer) + 1] . PHP_EOL;
