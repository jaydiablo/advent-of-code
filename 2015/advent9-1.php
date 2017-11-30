<?php

$input = 'Faerun to Norrath = 129
Faerun to Tristram = 58
Faerun to AlphaCentauri = 13
Faerun to Arbre = 24
Faerun to Snowdin = 60
Faerun to Tambi = 71
Faerun to Straylight = 67
Norrath to Tristram = 142
Norrath to AlphaCentauri = 15
Norrath to Arbre = 135
Norrath to Snowdin = 75
Norrath to Tambi = 82
Norrath to Straylight = 54
Tristram to AlphaCentauri = 118
Tristram to Arbre = 122
Tristram to Snowdin = 103
Tristram to Tambi = 49
Tristram to Straylight = 97
AlphaCentauri to Arbre = 116
AlphaCentauri to Snowdin = 12
AlphaCentauri to Tambi = 18
AlphaCentauri to Straylight = 91
Arbre to Snowdin = 129
Arbre to Tambi = 53
Arbre to Straylight = 40
Snowdin to Tambi = 15
Snowdin to Straylight = 99
Tambi to Straylight = 70';

//$input = 'London to Dublin = 464
//London to Belfast = 518
//Dublin to Belfast = 141';

$instructions = explode("\n", $input);

$locations = [];
$distances = [];

function getDistance($from, $to)
{
    global $locations;

    if (isset($locations[$from][$to])) {
        return $locations[$from][$to];
    } else {
        return $locations[$to][$from];
    }
}

foreach ($instructions as $line) {
    list($left, $to, $right, $equal, $distance) = explode(' ', $line);

    if (!isset($locations[$left])) {
        $locations[$left] = [];
    }
    if (!isset($locations[$right])) {
        $locations[$right] = [];
    }

    $locations[$left][$right] = (integer)$distance;
}

$matrix = [];
$locationKeys = array_keys($locations);

print_r($locationKeys);

function wordcombos ($words) {
    if ( count($words) <= 1 ) {
        $result = $words;
    } else {
        $result = array();
        for ( $i = 0; $i < count($words); ++$i ) {
            $firstword = $words[$i];
            $remainingwords = array();
            for ( $j = 0; $j < count($words); ++$j ) {
                if ( $i <> $j ) $remainingwords[] = $words[$j];
            }
            $combos = wordcombos($remainingwords);
            for ( $j = 0; $j < count($combos); ++$j ) {
                $result[] = $firstword . ' ' . $combos[$j];
            }
        }
    }

    return $result;
}

$matrix = wordcombos($locationKeys);

print_r($matrix);

$result = [];

foreach ($matrix as $route) {
    $route = explode(' ', $route);
    $to = null;
    $distance = 0;
    $text = '';
    while ($from = array_shift($route)) {
        $text .= $from . ' -> ';

        if (!$to) {
            $to = $from;
            continue;
        }

        $distance += getDistance($from, $to);

        $to = $from;
    }

    $result[substr($text, 0, -3)] = $distance;
    //echo substr($text, 0, -3) . '= ' . $distance . PHP_EOL;

}
arsort($result);
print_r($result);

//print_r($locations);
//print_r($matrix);
