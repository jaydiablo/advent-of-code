<?php

ini_set('memory_limit', '-1');

$input = '50
44
11
49
42
46
18
32
26
40
21
7
18
43
10
47
36
24
22
40';

$containers = explode("\n", $input);

$len  = count($containers);
$list = [];

for ($i = 1; $i < (1 << $len); $i++) {
    $c = [];
    for ($j = 0; $j < $len; $j++) {
        if ($i & (1 << $j)) {
            $c[] = $containers[$j];
        }
    }
    if (array_sum($c) == 150) {
        $list[] = $c;
    }
}

print count($list);