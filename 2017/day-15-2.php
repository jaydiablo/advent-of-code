<?php

ini_set('memory_limit', -1);

$a = '873';
$b = '583';

//$a = '65';
//$b = '8921';

$aFactor = '16807';
$bFactor = '48271';

$divisor = '2147483647';

$aTests = [];
$bTests = [];

$matches = 0;

$max = 5000000;

while (count($aTests) <= $max || count($bTests) <= $max) {
    if (count($aTests) <= $max) {
        $a = ($a * $aFactor) % $divisor;
        if ($a % 4 === 0) {
            $aTests[] = $a;
        }
    }
    if (count($bTests) <= $max) {
        $b = ($b * $bFactor) % $divisor;
        if ($b % 8 === 0) {
            $bTests[] = $b;
        }
    }
}

for ($i = 0, $count = count($aTests); $i < $count; $i++) {
    $a = $aTests[$i];
    $b = $bTests[$i];

    $abin = str_pad(base_convert($a, 10, 2), 32, 0, STR_PAD_LEFT);
    $bbin = str_pad(base_convert($b, 10, 2), 32, 0, STR_PAD_LEFT);

    if (substr($abin, -16) == substr($bbin, -16)) {
        $matches++;
    }
}

print $matches . PHP_EOL;
