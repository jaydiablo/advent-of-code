<?php

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

$input = 'Alice would gain 54 happiness units by sitting next to Bob.
Alice would lose 81 happiness units by sitting next to Carol.
Alice would lose 42 happiness units by sitting next to David.
Alice would gain 89 happiness units by sitting next to Eric.
Alice would lose 89 happiness units by sitting next to Frank.
Alice would gain 97 happiness units by sitting next to George.
Alice would lose 94 happiness units by sitting next to Mallory.
Bob would gain 3 happiness units by sitting next to Alice.
Bob would lose 70 happiness units by sitting next to Carol.
Bob would lose 31 happiness units by sitting next to David.
Bob would gain 72 happiness units by sitting next to Eric.
Bob would lose 25 happiness units by sitting next to Frank.
Bob would lose 95 happiness units by sitting next to George.
Bob would gain 11 happiness units by sitting next to Mallory.
Carol would lose 83 happiness units by sitting next to Alice.
Carol would gain 8 happiness units by sitting next to Bob.
Carol would gain 35 happiness units by sitting next to David.
Carol would gain 10 happiness units by sitting next to Eric.
Carol would gain 61 happiness units by sitting next to Frank.
Carol would gain 10 happiness units by sitting next to George.
Carol would gain 29 happiness units by sitting next to Mallory.
David would gain 67 happiness units by sitting next to Alice.
David would gain 25 happiness units by sitting next to Bob.
David would gain 48 happiness units by sitting next to Carol.
David would lose 65 happiness units by sitting next to Eric.
David would gain 8 happiness units by sitting next to Frank.
David would gain 84 happiness units by sitting next to George.
David would gain 9 happiness units by sitting next to Mallory.
Eric would lose 51 happiness units by sitting next to Alice.
Eric would lose 39 happiness units by sitting next to Bob.
Eric would gain 84 happiness units by sitting next to Carol.
Eric would lose 98 happiness units by sitting next to David.
Eric would lose 20 happiness units by sitting next to Frank.
Eric would lose 6 happiness units by sitting next to George.
Eric would gain 60 happiness units by sitting next to Mallory.
Frank would gain 51 happiness units by sitting next to Alice.
Frank would gain 79 happiness units by sitting next to Bob.
Frank would gain 88 happiness units by sitting next to Carol.
Frank would gain 33 happiness units by sitting next to David.
Frank would gain 43 happiness units by sitting next to Eric.
Frank would gain 77 happiness units by sitting next to George.
Frank would lose 3 happiness units by sitting next to Mallory.
George would lose 14 happiness units by sitting next to Alice.
George would lose 12 happiness units by sitting next to Bob.
George would lose 52 happiness units by sitting next to Carol.
George would gain 14 happiness units by sitting next to David.
George would lose 62 happiness units by sitting next to Eric.
George would lose 18 happiness units by sitting next to Frank.
George would lose 17 happiness units by sitting next to Mallory.
Mallory would lose 36 happiness units by sitting next to Alice.
Mallory would gain 76 happiness units by sitting next to Bob.
Mallory would lose 34 happiness units by sitting next to Carol.
Mallory would gain 37 happiness units by sitting next to David.
Mallory would gain 40 happiness units by sitting next to Eric.
Mallory would gain 18 happiness units by sitting next to Frank.
Mallory would gain 7 happiness units by sitting next to George.';

/*$input = 'Alice would gain 54 happiness units by sitting next to Bob.
Alice would lose 79 happiness units by sitting next to Carol.
Alice would lose 2 happiness units by sitting next to David.
Bob would gain 83 happiness units by sitting next to Alice.
Bob would lose 7 happiness units by sitting next to Carol.
Bob would lose 63 happiness units by sitting next to David.
Carol would lose 62 happiness units by sitting next to Alice.
Carol would gain 60 happiness units by sitting next to Bob.
Carol would gain 55 happiness units by sitting next to David.
David would gain 46 happiness units by sitting next to Alice.
David would lose 7 happiness units by sitting next to Bob.
David would gain 41 happiness units by sitting next to Carol.';*/

$instructions = explode("\n", $input);

$people = [];

function calculateValue($person1, $person2)
{
    global $people;

    $value = 0;

    $value += $people[$person1][$person2];
    $value += $people[$person2][$person1];

    return $value;
}

foreach ($instructions as $line) {
    $parsed = explode(' ', $line);

    $left = $parsed[0];
    $operation = $parsed[2];
    $amount = $parsed[3];
    if ($operation == 'lose') {
        $amount = $amount * -1;
    }
    $right = str_replace('.', '', array_pop($parsed));

    if (!isset($people[$left])) {
        $people[$left] = [];
    }
    $people[$left][$right] = $amount;
}

$possible = wordcombos(array_keys($people));

$arrangements = [];

foreach ($possible as $arrangement) {
    $peeps = explode(' ', $arrangement);

    $value = 0;

    for ($i = 0, $count = count($peeps); $i < $count; $i++) {
        $peep = $peeps[$i];
        if ($i - 1 < 0) {
            $left = $peeps[$count - 1];
        } else {
            $left = $peeps[$i - 1];
        }

        $value += calculateValue($peep, $left);
    }

    $arrangements[$arrangement] = $value;
}

asort($arrangements);

print_r($arrangements);

//print_r($people);
//print_r($possible);