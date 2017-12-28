<?php

$input = 'Begin in state A.
Perform a diagnostic checksum after 6 steps.

In state A:
  If the current value is 0:
    - Write the value 1.
    - Move one slot to the right.
    - Continue with state B.
  If the current value is 1:
    - Write the value 0.
    - Move one slot to the left.
    - Continue with state B.

In state B:
  If the current value is 0:
    - Write the value 1.
    - Move one slot to the left.
    - Continue with state A.
  If the current value is 1:
    - Write the value 1.
    - Move one slot to the right.
    - Continue with state A.';

$input = 'Begin in state A.
Perform a diagnostic checksum after 12134527 steps.

In state A:
  If the current value is 0:
    - Write the value 1.
    - Move one slot to the right.
    - Continue with state B.
  If the current value is 1:
    - Write the value 0.
    - Move one slot to the left.
    - Continue with state C.

In state B:
  If the current value is 0:
    - Write the value 1.
    - Move one slot to the left.
    - Continue with state A.
  If the current value is 1:
    - Write the value 1.
    - Move one slot to the right.
    - Continue with state C.

In state C:
  If the current value is 0:
    - Write the value 1.
    - Move one slot to the right.
    - Continue with state A.
  If the current value is 1:
    - Write the value 0.
    - Move one slot to the left.
    - Continue with state D.

In state D:
  If the current value is 0:
    - Write the value 1.
    - Move one slot to the left.
    - Continue with state E.
  If the current value is 1:
    - Write the value 1.
    - Move one slot to the left.
    - Continue with state C.

In state E:
  If the current value is 0:
    - Write the value 1.
    - Move one slot to the right.
    - Continue with state F.
  If the current value is 1:
    - Write the value 1.
    - Move one slot to the right.
    - Continue with state A.

In state F:
  If the current value is 0:
    - Write the value 1.
    - Move one slot to the right.
    - Continue with state A.
  If the current value is 1:
    - Write the value 1.
    - Move one slot to the right.
    - Continue with state E.';

$lines = explode("\n", $input);

$states = [];

$inState = '';
$curVal = '';

foreach ($lines as $line) {
    if (preg_match('/^Begin in state (?P<startState>[A-Z])\.$/', $line, $matches)) {
        $state = $matches['startState'];
    } elseif (preg_match('/^Perform a diagnostic checksum after (?P<steps>[\d]+) steps\.$/', $line, $matches)) {
        $steps = $matches['steps'];
    } elseif (preg_match('/^In state (?P<state>[A-Z]):$/', $line, $matches)) {
        $inState = $matches['state'];
        $states[$inState] = [];
    } elseif (preg_match('/^\s+If the current value is (?P<curVal>(0|1)):$/', $line, $matches)) {
        $curVal = $matches['curVal'];
        $states[$inState][$curVal] = [];
    } elseif (preg_match('/^\s+- Write the value (?P<writeVal>(0|1))\.$/', $line, $matches)) {
        $states[$inState][$curVal]['write'] = $matches['writeVal'];
    } elseif (preg_match('/^\s+- Move one slot to the (?P<direction>(left|right))\.$/', $line, $matches)) {
        $states[$inState][$curVal]['direction'] = $matches['direction'];
    } elseif (preg_match('/^\s+- Continue with state (?P<newState>[A-Z])\.$/', $line, $matches)) {
        $states[$inState][$curVal]['newState'] = $matches['newState'];
    }
}

$tape = [];
$pos = 0;

for ($i = 0; $i < $steps; $i++) {
    if (!isset($tape[$pos])) {
        $tape[$pos] = 0;
    }

    $rules = $states[$state][$tape[$pos]];

    $tape[$pos] = $rules['write'];
    switch ($rules['direction']) {
        case 'left':
            $pos--;
            break;
        case 'right':
            $pos++;
            break;
    }
    $state = $rules['newState'];
}

print array_count_values($tape)[1] . PHP_EOL;
