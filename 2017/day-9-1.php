<?php

$input = '{}';
$input = '{{{}}}';
$input = '{{},{}}';
$input = '{{{},{},{{}}}}';
$input = '{<a>,<a>,<a>,<a>}';
$input = '{{<ab>},{<ab>},{<ab>},{<ab>}}';
$input = '{{<!!>},{<!!>},{<!!>},{<!!>}}';
$input = '{{<a!>},{<a!>},{<a!>},{<ab>}}';

$input = file_get_contents(__DIR__ . '/files/day-9.txt');

$depth = 0;
$score = 0;

function handleGroup(array &$input, int &$depth) {
    $depth++;

    $ignore = false;
    $score = $depth;

    while (count($input) > 0) {
        $char = array_shift($input);

        if ($ignore === true) {
            $ignore = false;
            continue;
        }

        switch ($char) {
            case '}':
                $depth--;
                return $score;
            case '!':
                $ignore = true;
                break;
            case '<':
                handleGarbage($input);
                break;
            case '{':
                $score += handleGroup($input, $depth);
                break;
        }
    }
}

function handleGarbage(&$input) {
    $ignore = false;

    while (count($input) > 0) {
        $char = array_shift($input);

        if ($ignore === true) {
            $ignore = false;
            continue;
        }

        switch ($char) {
            case '>':
                return;
            case '!':
                $ignore = true;
                break;
        }
    }
}

$chars = str_split($input);
array_shift($chars);

$score += handleGroup($chars, $depth);

print $score . PHP_EOL;