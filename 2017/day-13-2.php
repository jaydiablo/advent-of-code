<?php

$input = '0: 3
1: 2
4: 4
6: 4';

$input = '0: 3
1: 2
2: 6
4: 4
6: 4
8: 8
10: 9
12: 8
14: 5
16: 6
18: 8
20: 6
22: 12
24: 6
26: 12
28: 8
30: 8
32: 10
34: 12
36: 12
38: 8
40: 12
42: 12
44: 14
46: 12
48: 14
50: 12
52: 12
54: 12
56: 10
58: 14
60: 14
62: 14
64: 14
66: 17
68: 14
72: 14
76: 14
80: 14
82: 14
88: 18
92: 14
98: 18';

$lines = explode("\n", $input);

$layers = [];

foreach ($lines as $line) {
    [$layer, $range] = explode(': ', $line);

    $layers[$layer] =  ['range' => $range, 'position' => 0, 'direction' => 'down'];
}

$delay = 0;

function moveScanners(&$layers) {
    foreach ($layers as $layer => $data) {
        if ($data['direction'] === 'down') {
            if ($data['position'] === $data['range'] - 1) {
                $layers[$layer]['position']--;
                $layers[$layer]['direction'] = 'up';
            } else {
                $layers[$layer]['position']++;
            }
        } else {
            if ($data['position'] === 0) {
                $layers[$layer]['position']++;
                $layers[$layer]['direction'] = 'down';
            } else {
                $layers[$layer]['position']--;
            }
        }
    }
}

$previousLayers = $layers;

do {
    $caught = [];
    $layers = $previousLayers;

    if ($delay > 0) {
        moveScanners($layers);
    }

    $previousLayers = $layers;

    for ($i = 0, $last = max(array_keys($layers)); $i <= $last; $i++) {
        if (isset($layers[$i])) {
            if ($layers[$i]['position'] ===  0) {
                $caught[] = $i;
                break;
            }
        }

        moveScanners($layers);
    }

    $delay++;
} while (count($caught) > 0);

print $delay - 1 . PHP_EOL;
