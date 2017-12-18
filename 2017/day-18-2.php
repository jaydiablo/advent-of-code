<?php

$input = 'snd 1
snd 2
snd p
rcv a
rcv b
rcv c
rcv d';

$input = 'set i 31
set a 1
mul p 17
jgz p p
mul a 2
add i -1
jgz i -2
add a -1
set i 127
set p 826
mul p 8505
mod p a
mul p 129749
add p 12345
mod p a
set b p
mod b 10000
snd b
add i -1
jgz i -9
jgz a 3
rcv b
jgz b -1
set f 0
set i 126
rcv a
rcv b
set p a
mul p -1
add p b
jgz p 4
snd a
set a b
jgz 1 3
snd b
set f 1
add i -1
jgz i -11
snd a
jgz f -16
jgz a -19';

$registers = [
    0 => ['p' => 0],
    1 => ['p' => 1],
];
$queue = [
    0 => [],
    1 => [],
];
$positions = [
    0 => 0,
    1 => 0,
];
$sends = 0;

$current = 0;

$instructions = explode("\n", $input);

function run($id, &$i, &$registers) {
    global $instructions, $sends, $queue;

    for ($count = count($instructions); $i < $count && $i >= 0; $i++) {
        $instruction = $instructions[$i];

        [$command, $x, $y] = array_pad(explode(' ', $instruction), 3, null);


        if (!is_numeric($x) && !isset($registers[$x])) {
            $registers[$x] = 0;
        }

        if (!empty($y) && !is_numeric($y) && !isset($registers[$y])) {
            $registers[$y] = 0;
        }

        if (!empty($y)) {
            if (!is_numeric($y)) {
                $yValue = $registers[$y];
            } else {
                $yValue = $y;
            }
        } else {
            $yValue = '';
        }

        switch ($command) {
            case 'add':
                $registers[$x] += $yValue;
                break;
            case 'mul':
                $registers[$x] *= $yValue;
                break;
            case 'mod':
                $registers[$x] %= $yValue;
                break;
            case 'snd':
                if ($id === 0) {
                    $other = 1;
                } else {
                    $sends++;
                    $other = 0;
                }
                if (is_numeric($x)) {
                    $queue[$other][] = $x;
                } else {
                    $queue[$other][] = $registers[$x];
                }
                break;
            case 'set':
                $registers[$x] = $yValue;
                break;
            case 'rcv':
                if (empty($queue[$id])) {
                    return;
                } else {
                    $registers[$x] = array_shift($queue[$id]);
                }
                break;
            case 'jgz':
                if (!is_numeric($x)) {
                    $x = $registers[$x];
                }
                if ($x > 0) {
                    $i += $yValue - 1;
                }
                break;
        }
    }
}

while (true) {
    run($current, $positions[$current], $registers[$current]);

    if (empty($queue[0]) && empty($queue[1])) {
        break;
    }

    if ($current === 0) {
        $current = 1;
    } else {
        $current = 0;
    }
}

print $sends . PHP_EOL;
