<?php

$input = 'set b 99
set c b
jnz a 2
jnz 1 5
mul b 100
sub b -100000
set c b
sub c -17000
set f 1
set d 2
set e 2
set g d
mul g e
sub g b
jnz g 2
set f 0
sub e -1
set g e
sub g b
jnz g -8
sub d -1
set g d
sub g b
jnz g -13
jnz f 2
sub h -1
set g b
sub g c
jnz g 2
jnz 1 3
sub b -17
jnz 1 -23';

$registers = [];
$sounds = [];

$instructions = explode("\n", $input);

$muls = 0;

for ($i = 0, $count = count($instructions); $i < $count && $i >= 0; $i++) {
    $instruction = $instructions[$i];

    [$command, $x, $y] = array_pad(explode(' ', $instruction), 3, null);

    if (!isset($registers[$x])) {
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
        case 'sub':
            $registers[$x] -= $yValue;
            break;
        case 'mul':
            $registers[$x] *= $yValue;
            $muls++;
            break;
        case 'mod':
            $registers[$x] %= $yValue;
            break;
        case 'snd':
            $sounds[] = $registers[$x];
            break;
        case 'set':
            $registers[$x] = $yValue;
            break;
        case 'rcv':
            if ($registers[$x] != 0) {
                echo array_pop($sounds) . PHP_EOL;
                exit;
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
        case 'jnz':
            if (!is_numeric($x)) {
                $x = $registers[$x];
            }
            if ($x != 0) {
                $i += $yValue - 1;
            }
            break;
    }
}

print $muls . PHP_EOL;
