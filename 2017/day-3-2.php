<?php

$input = 347991;

$positions = [
    'x0y0' => 1,
];

$position = ['x' => 0, 'y' => 0];

$directions = ['x', 'y', '-x', '-y', '-xy', 'x-y', 'xy', '-x-y'];

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
        case '-xy':
            $position['x']--;
            $position['y']++;
            break;
        case 'x-y':
            $position['x']++;
            $position['y']--;
            break;
        case 'xy':
            $position['x']++;
            $position['y']++;
            break;
        case '-x-y':
            $position['x']--;
            $position['y']--;
            break;
    }

    return $position;
}

// Build grid
while ($value < $input) {

    $position = move($direction, $position);
    $value = 0;

    foreach ($directions as $test) {
        $neighbor = move($test, $position);

        if (isset($positions['x' . $neighbor['x'] . 'y' . $neighbor['y']])) {
            $value += $positions['x' . $neighbor['x'] . 'y' . $neighbor['y']];
        }
    }

    if ($position['x'] == 0 && $position['y'] == 0) {
        $value = 1;
    }

    $positions['x' . $position['x'] . 'y' . $position['y']] = $value;

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

print $value . PHP_EOL;
