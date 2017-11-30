<?php

$elves = [];

for ($i = 1; $i <= 50000; $i++) {
    $elves[] = $i;
}

$houses = [];

for ($i = 1; $i <= 50000; $i++) {
    $houses[] = $i;
}

$gifts = [];

foreach ($houses as $house) {
    foreach ($elves as $elf) {
        if ($house % $elf == 0) {
            if (!isset($gifts['house' . $house])) {
                $gifts['house' . $house] = 0;
            }
            $gifts['house' . $house] += 10 * $elf;
        }
    }
}


$max = max($gifts);

if ($max >= '34000000') {
    foreach ($gifts as $house => $value) {
        if ($value >= '340000000') {
            print $house . ' = ' . $value . PHP_EOL;
        }
    }
} else {
    print 'Max value not reached. Max was ' . $max . PHP_EOL;
}