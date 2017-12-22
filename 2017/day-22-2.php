<?php

$input = '..#
#..
...';

$input = '.#...#.#.##..##....##.#.#
###.###..##...##.##....##
....#.###..#...#####..#.#
.##.######..###.##..#...#
#..#..#..##..###...#..###
..####...#.##.#.#.##.####
#......#..####..###..###.
#####.##.#.#.##.###.#.#.#
.#.###....###....##....##
.......########.#.#...#..
...###.####.##..###.##..#
#.#.###.####.###.###.###.
.######...###.....#......
....##.###..#.#.###...##.
#.###..###.#.#.##.#.##.##
#.#.#..###...###.###.....
##..##.##...##.##..##.#.#
.....##......##..#.##...#
..##.#.###.#...#####.#.##
....##..#.#.#.#..###.#..#
###..##.##....##.#....##.
#..####...####.#.##..#.##
####.###...####..##.#.#.#
#.#.#.###.....###.##.###.
.#...##.#.##..###.#.###..';

$lines = explode("\n", $input);

$grid = [];

$height = count($lines);
$width = strlen($lines[0]);

$vMiddle = ceil($height / 2);
$hMiddle = ceil($width / 2);

$maxY = 0;
$minY = 0;
$maxX = 0;
$minX = 0;

function pretty($grid, $pos) {
    global $minX, $maxX, $minY, $maxY;

    $out = '';

    foreach (range($minY, $maxY) as $y) {
        foreach (range($minX, $maxX) as $x)  {
            if ($pos['x'] == $x && $pos['y'] == $y) {
                $out .= "\033[32m";
            }
            if (isset($grid['y' . $y]['x' . $x])) {
                $out .= $grid['y' . $y]['x' . $x];
            } else {
                $out .= '.';
            }
            if ($pos['x'] == $x && $pos['y'] == $y) {
                $out .= "\033[0m";
            }
        }

        $out .= PHP_EOL;
    }

    return $out;
}

for ($y = $vMiddle - $height, $i = 0; $i < $height; $y++, $i++) {
    $chars = str_split($lines[$i]);

    for ($x = $hMiddle - $width, $j = 0; $j < $width; $x++, $j++) {
        $grid['y' . $y]['x' . $x] = $chars[$j];

        $maxY = max($maxY, $y);
        $maxX = max($maxX, $x);
        $minY = min($minY, $y);
        $minX = min($minX, $x);
    }
}

$pos = ['x' => 0, 'y' => 0];
$direction = 'up';

function changeDirection($current, $turn) {
    $new  = '';
    switch ($current) {
        case 'up':
            if ($turn === 'right')  {
                $new = 'right';
            } else {
                $new = 'left';
            }
            break;
        case 'down':
            if ($turn === 'right')  {
                $new = 'left';
            } else {
                $new = 'right';
            }
            break;
        case 'right':
            if ($turn === 'right')  {
                $new = 'down';
            } else {
                $new = 'up';
            }
            break;
        case 'left':
            if ($turn === 'right')  {
                $new = 'up';
            } else {
                $new = 'down';
            }
            break;
    }

    return $new;
}

function move($pos, $direction) {
    switch ($direction) {
        case 'up':
            $pos['y'] -= 1;
            break;
        case 'down':
            $pos['y'] += 1;
            break;
        case 'left':
            $pos['x'] -= 1;
            break;
        case 'right':
            $pos['x'] += 1;
            break;
    }

    return $pos;
}

$infections = 0;

for ($i = 0; $i < 10000000; $i++) {
    if (!isset($grid['y' . $pos['y']])) {
        $grid['y' . $pos['y']] = [];
    }
    if (!isset($grid['y' . $pos['y']]['x' . $pos['x']])) {
        $grid['y' . $pos['y']]['x' . $pos['x']] = '.';
    }

    if ($grid['y' . $pos['y']]['x' . $pos['x']] === '#') {
        $direction = changeDirection($direction, 'right');
        $grid['y' . $pos['y']]['x' . $pos['x']] = 'F';
    } elseif ($grid['y' . $pos['y']]['x' . $pos['x']] === 'W') {
        $grid['y' . $pos['y']]['x' . $pos['x']] = '#';
        $infections++;
    } elseif ($grid['y' . $pos['y']]['x' . $pos['x']] === 'F') {
        $direction = changeDirection($direction, 'left');
        $direction = changeDirection($direction, 'left');
        $grid['y' . $pos['y']]['x' . $pos['x']] = '.';
    } else {
        $direction = changeDirection($direction, 'left');
        $grid['y' . $pos['y']]['x' . $pos['x']] = 'W';
    }

    $pos = move($pos, $direction);

    $maxY = max($maxY, $pos['y']);
    $maxX = max($maxX, $pos['x']);
    $minY = min($minY, $pos['y']);
    $minX = min($minX, $pos['x']);
}

print pretty($grid, $pos) . PHP_EOL;

print $infections . PHP_EOL;
