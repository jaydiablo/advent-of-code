<?php

$input = 'Frosting: capacity 4, durability -2, flavor 0, texture 0, calories 5
Candy: capacity 0, durability 5, flavor -1, texture 0, calories 8
Butterscotch: capacity -1, durability 0, flavor 5, texture 0, calories 6
Sugar: capacity 0, durability 0, flavor -2, texture 2, calories 1';

$lines = explode("\n", $input);

$ingredients = [];

foreach ($lines as $line) {
    list($ingredient, $cap, $capacity, $dur, $durability, $fla, $flavor, $tex, $texture, $cal, $calories) = explode(' ', $line);

    $ingredients[substr($ingredient, 0, -1)] = [
        'capacity' => substr($capacity, 0, -1),
        'durability' => substr($durability, 0, -1),
        'flavor' => substr($flavor, 0, -1),
        'texture' => substr($texture, 0, -1),
        'calories' => $calories
    ];
}

$rows = [];

foreach (range(0, 100) as $a) {
    $row['Frosting'] = $a;
    if (array_sum($row) == 100) {
        $row['Candy'] = 0;
        $row['Butterscotch'] = 0;
        $row['Sugar'] = 0;
        $rows[] = $row;
        continue;
    }
    foreach (range(0, 100) as $b) {
        $row['Candy'] = $b;
        if (array_sum($row) == 100) {
            $row['Butterscotch'] = 0;
            $row['Sugar'] = 0;
            $rows[] = $row;
            continue;
        }
        foreach (range(0, 100) as $c) {
            $row['Butterscotch'] = $c;
            if (array_sum($row) == 100) {
                $row['Sugar'] = 0;
                $rows[] = $row;
                continue;
            }
            foreach (range(0, 100) as $d) {
                $row['Sugar'] = $d;

                if (array_sum($row) == 100) {
                    $rows[] = $row;
                }
            }
        }
    }
}

//print_r($rows);

$totals = [];

foreach ($rows as $row) {
    $cap = 0;
    $dur = 0;
    $fla = 0;
    $tex = 0;

    foreach ($row as $ingredient => $amount) {
        $cap += $ingredients[$ingredient]['capacity'] * $amount;
        $dur += $ingredients[$ingredient]['durability'] * $amount;
        $fla += $ingredients[$ingredient]['flavor'] * $amount;
        $tex += $ingredients[$ingredient]['texture'] * $amount;
    }

    if ($cap < 0) {
        $cap = 0;
    }
    if ($dur < 0) {
        $dur = 0;
    }
    if ($fla < 0) {
        $fla = 0;
    }
    if ($tex < 0) {
        $tex = 0;
    }

    $totals[] = $cap * $dur * $fla * $tex;
}

asort($totals);

print_r($totals);