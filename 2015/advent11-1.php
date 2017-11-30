<?php

$input = 'hxbxwxba';

// build array of possible 3 char strings?
$first = 'a';
$last = '';
$strings = [];

while ($first != 'y') {
    $string = $first;
    for ($i = 0; $i < 2; $i++) {
        $string .= ++$first;
    }
    $first = substr($string, 0, 1);
    $first++;
    $strings[] = $string;
}

function passwordCheck($in) {
    global $strings;

    // One straight of characters 3 long
    // preg expression from string
    $regex = implode('|', $strings);
    if (!preg_match('/' . $regex . '/', $in)) {
        return false;
    }

    // No i, o or l
    if (strstr($in, 'i') || strstr($in, 'o') || strstr($in, 'l')) {
        return false;
    }

    // different pairs
    if (!preg_match('|^.*([a-z])\1.*([^\1])\2.*$|', $in)) {
        return false;
    }

    // make sure not 3 chars in a row
    if (preg_match('|([a-z])\1\1|', $in)) {
        return false;
    }

    return true;
}

do {
    $input++;
} while (passwordCheck($input) === false);

print $input;