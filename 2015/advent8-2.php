<?php

$input = file_get_contents('./advent8-2.txt');

$lines = array_filter(explode("\n", $input));

$output = '';

foreach ($lines as $line) {
    $line = addslashes($line);
    $output .= '"' . $line . '"';
}

echo $output;
echo strlen($output);