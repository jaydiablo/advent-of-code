<?php

function is_prime($number)
{
    // 1 is not prime
    if ( $number == 1 ) {
        return false;
    }
    // 2 is the only even prime number
    if ( $number == 2 ) {
        return true;
    }
    // square root algorithm speeds up testing of bigger prime numbers
    $x = sqrt($number);
    $x = floor($x);
    for ( $i = 2 ; $i <= $x ; ++$i ) {
        if ( $number % $i == 0 ) {
            break;
        }
    }

    if( $x == $i-1 ) {
        return true;
    } else {
        return false;
    }
}

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

$registers = [
    'a' => 1,
    'b' => 0,
    'c' => 0,
    'd' => 0,
    'e' => 0,
    'f' => 0,
    'g' => 0,
    'h' => 0,
];

// set b 99
$registers['b'] = 99;
// set c b
$registers['c'] = $registers['b'];

// jnz a 2
// jnz 1 5
if ($registers['a'] !== 0) {
    // mul b 100
    //$muls++;
    $registers['b'] *= 100;
    // sub b -100000
    $registers['b'] += 100000;
    // set c b
    $registers['c'] = $registers['b'];
    // sub c -17000
    $registers['c'] += 17000;
}

// jnz 1 -23
while (true) {
    // set f 1
    $registers['f'] = 1;
    // set d 2
    $registers['d'] = 2;

    if (!is_prime($registers['b'])) {
        $registers['f'] = 0;
    }

    // jnz g -13
    do {
        // set e 2
        $registers['e'] = 2;
        // jnz g -8
        /*if ($registers['f'] !== 0) {
            do {
                // set g d
                $registers['g'] = $registers['d'];
                // mul g e
                $registers['g'] *= $registers['e'];
                //$muls++;
                // sub g b
                $registers['g'] -= $registers['b'];

                // jnz g 2
                if ($registers['g'] === 0) {
                    // set f 0
                    $registers['f'] = 0;
                    // Short circuit this loop
                    $registers['g'] = 0;
                    $registers['e'] = $registers['b'];
                    break;
                }
                // sub e -1
                $registers['e']++;
                // set g e
                $registers['g'] = $registers['e'];
                // sub g b
                $registers['g'] -= $registers['b'];
            } while ($registers['g'] !== 0);
        }*/

        // Replacement for do/while above:
        $registers['e'] = $registers['b'];
        $registers['g'] = 0;

        // sub d -1
        $registers['d']++;
        // set g d
        $registers['g'] = $registers['d'];
        // sub g b
        $registers['g'] -= $registers['b'];
    } while ($registers['g'] !== 0);

    // jnz f 2
    if ($registers['f'] === 0) {
        // sub h -1
        $registers['h']++;
    }

    // set g b
    $registers['g'] = $registers['b'];
    // sub g c
    $registers['g'] -= $registers['c'];
    // jnz g 2
    if ($registers['g'] === 0) {
        // jnz 1 3
        print $registers['h'] . PHP_EOL;
        exit;
    } else {
        //sub b -17
        $registers['b'] += 17;
    }
}
