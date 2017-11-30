<?php

$string = 'ckczppom';
//$string = 'abcdef';
$hash = '';

for ($i = 0; substr($hash, 0, 6) !== '000000'; $i++) {
$hash = md5($string . $i);
}

echo $hash. PHP_EOL;
echo ($i - 1) . PHP_EOL;

