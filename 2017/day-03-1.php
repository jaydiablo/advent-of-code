<?php

$input = 347991;

//$input = 1024;

$positions = [
    'x0y0' => 1,
];

$position = ['x' => 0, 'y' => 0];

$directions = ['x', 'y', '-x', '-y'];

$direction = 'x';

function move($direction, $position)
{
    switch ($direction) {
        case 'x':
            $position['x']++;
            break;
        case 'y':
            $position['y']++;
            break;
        case '-x':
            $position['x']--;
            break;
        case '-y':
            $position['y']--;
            break;
    }

    return $position;
}

// Build grid
for ($i = 1; $i < $input; $i++) {

    $position = move($direction, $position);

    $positions['x' . $position['x'] . 'y' . $position['y']] = $i  + 1;

    switch ($direction) {
        case 'x':
            $newDirection = 'y';
            break;
        case 'y':
            $newDirection = '-x';
            break;
        case '-x':
            $newDirection = '-y';
            break;
        case '-y':
            $newDirection = 'x';
            break;
    }

    $test = move($newDirection, $position);

    if (!isset($positions['x' . $test['x'] . 'y' . $test['y']])) {
        $direction = $newDirection;
    }
}

$distance = abs($position['x']) + abs($position['y']);

print $distance . PHP_EOL;
