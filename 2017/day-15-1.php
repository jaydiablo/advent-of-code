<?php

$a = '873';
$b = '583';

$aFactor = '16807';
$bFactor = '48271';

$divisor = '2147483647';

$matches = 0;

for ($i = 0; $i < 40000000; $i++) {
    $a = ($a * $aFactor) % $divisor;
    $b = ($b * $bFactor) % $divisor;

    $abin = str_pad(base_convert($a, 10, 2), 32, 0, STR_PAD_LEFT);
    $bbin = str_pad(base_convert($b, 10, 2), 32, 0, STR_PAD_LEFT);

    if (substr($abin, -16) == substr($bbin, -16)) {
        $matches++;
    }
}

print $matches . PHP_EOL;
