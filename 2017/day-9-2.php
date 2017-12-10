<?php

$input = '{<>}';
$input = '{<random characters>}';
$input = '{<<<<>}';
$input = '{<{!>}>}';
$input = '{<!!>}';
$input = '{<!!!>>}';
$input = '{<{o"i!a,<{i<a>}';

$input = file_get_contents(__DIR__ . '/files/day-9.txt');

$garbage = 0;

function handleGroup(array &$input, int &$garbage) {
    $ignore = false;

    while (count($input) > 0) {
        $char = array_shift($input);

        if ($ignore === true) {
            $ignore = false;
            continue;
        }

        switch ($char) {
            case '}':
                return;
            case '!':
                $ignore = true;
                break;
            case '<':
                handleGarbage($input, $garbage);
                break;
            case '{':
                handleGroup($input, $garbage);
                break;
        }
    }
}

function handleGarbage(array &$input, int &$garbage) {
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
            default:
                $garbage++;
                break;
        }
    }
}

$chars = str_split($input);
array_shift($chars);

handleGroup($chars, $garbage);

print $garbage . PHP_EOL;
