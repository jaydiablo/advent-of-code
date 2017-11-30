<?php

$input = 'Rudolph can fly 22 km/s for 8 seconds, but then must rest for 165 seconds.
Cupid can fly 8 km/s for 17 seconds, but then must rest for 114 seconds.
Prancer can fly 18 km/s for 6 seconds, but then must rest for 103 seconds.
Donner can fly 25 km/s for 6 seconds, but then must rest for 145 seconds.
Dasher can fly 11 km/s for 12 seconds, but then must rest for 125 seconds.
Comet can fly 21 km/s for 6 seconds, but then must rest for 121 seconds.
Blitzen can fly 18 km/s for 3 seconds, but then must rest for 50 seconds.
Vixen can fly 20 km/s for 4 seconds, but then must rest for 75 seconds.
Dancer can fly 7 km/s for 20 seconds, but then must rest for 119 seconds.';

$duration = 2503;

/*$input = 'Comet can fly 14 km/s for 10 seconds, but then must rest for 127 seconds.
Dancer can fly 16 km/s for 11 seconds, but then must rest for 162 seconds.';
$duration = 1000;*/

$lines = explode("\n", $input);

$reindeer = [];
$tracking = [];

foreach ($lines as $line) {
    list($deer, $can, $fly, $speed, $unit, $for, $moveTime, $seconds, $but, $then, $must, $rest, $for, $restTime, $seconds2) = explode(' ', $line);

    $reindeer[$deer] = ['speed' => $speed, 'moveTime' => $moveTime, 'restTime' => $restTime];
    $tracking[$deer] = ['traveled' => 0, 'restDuration' => 0, 'moveDuration' => 0, 'resting' => false, 'totalRest' => 0, 'totalMove' => 0];
}

print_r($reindeer);

for ($i = 0; $i < $duration; $i++) {
//    print $i . PHP_EOL;
    foreach ($reindeer as $deer => $data) {
        if ($tracking[$deer]['resting'] === false) {
            if ($tracking[$deer]['moveDuration'] < $data['moveTime']) {
                $tracking[$deer]['moveDuration']++;
                $tracking[$deer]['totalMove']++;
                $tracking[$deer]['traveled'] += $data['speed'];
            } elseif ($tracking[$deer]['moveDuration'] == $data['moveTime']) {
                print 'It has been ' . $tracking[$deer]['moveDuration'] . ' seconds so ' . $deer . ' needs to rest (has moved ' . $tracking[$deer]['traveled'] . ' km so far)' . PHP_EOL;
                $tracking[$deer]['moveDuration'] = 0;
                $tracking[$deer]['resting'] = true;
                $tracking[$deer]['totalRest']++;
                $tracking[$deer]['restDuration'] = 1;
            } else {
                throw new Exception('Not allowed to have movement duration greater than allowed time');
            }

            //$tracking[$deer]['traveled'] += $data['speed'];
        } else {
            if ($tracking[$deer]['restDuration'] < $data['restTime']) {
                $tracking[$deer]['totalRest']++;
                $tracking[$deer]['restDuration']++;
            } elseif ($tracking[$deer]['restDuration'] == $data['restTime']) {
                print 'It has been ' . $tracking[$deer]['restDuration'] . ' seconds so ' . $deer . ' will start moving again' . PHP_EOL;
                $tracking[$deer]['restDuration'] = 0;
                $tracking[$deer]['resting'] = false;
                $tracking[$deer]['moveDuration'] = 1;
                $tracking[$deer]['traveled'] += $data['speed'];
                $tracking[$deer]['totalMove']++;
            } else {
                throw new Exception('Not allowed to have rest duration greater than allowed time');
            }
        }
    }
}


print_r($tracking);

foreach ($tracking as $deer => $data) {
    print $deer . ' moved for ' . $data['totalMove'] . ' seconds which should = ' . $data['totalMove'] * $reindeer[$deer]['speed'] . ' but resulted in ' . $data['traveled'] . PHP_EOL;
}
