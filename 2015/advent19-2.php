<?php

ini_set('memory_limit', -1);

function shuffle_assoc(&$array) {
    $keys = array_keys($array);

    shuffle($keys);

    foreach($keys as $key) {
        $new[$key] = $array[$key];
    }

    $array = $new;

    return true;
}

$input = 'Al => ThF
Al => ThRnFAr
B => BCa
B => TiB
B => TiRnFAr
Ca => CaCa
Ca => PB
Ca => PRnFAr
Ca => SiRnFYFAr
Ca => SiRnMgAr
Ca => SiTh
F => CaF
F => PMg
F => SiAl
H => CRnAlAr
H => CRnFYFYFAr
H => CRnFYMgAr
H => CRnMgYFAr
H => HCa
H => NRnFYFAr
H => NRnMgAr
H => NTh
H => OB
H => ORnFAr
Mg => BF
Mg => TiMg
N => CRnFAr
N => HSi
O => CRnFYFAr
O => CRnMgAr
O => HP
O => NRnFAr
O => OTi
P => CaP
P => PTi
P => SiRnFAr
Si => CaSi
Th => ThCa
Ti => BP
Ti => TiTi
e => HF
e => NAl
e => OMg';

$medicine = 'ORnPBPMgArCaCaCaSiThCaCaSiThCaCaPBSiRnFArRnFArCaCaSiThCaCaSiThCaCaCaCaCaCaSiRnFYFArSiRnMgArCaSiRnPTiTiBFYPBFArSiRnCaSiRnTiRnFArSiAlArPTiBPTiRnCaSiAlArCaPTiTiBPMgYFArPTiRnFArSiRnCaCaFArRnCaFArCaSiRnSiRnMgArFYCaSiRnMgArCaCaSiThPRnFArPBCaSiRnMgArCaCaSiThCaSiRnTiMgArFArSiThSiThCaCaSiRnMgArCaCaSiRnFArTiBPTiRnCaSiAlArCaPTiRnFArPBPBCaCaSiThCaPBSiThPRnFArSiThCaSiThCaSiThCaPTiBSiRnFYFArCaCaPRnFArPBCaCaPBSiRnTiRnFArCaPRnFArSiRnCaCaCaSiThCaRnCaFArYCaSiRnFArBCaCaCaSiThFArPBFArCaSiRnFArRnCaCaCaFArSiRnFArTiRnPMgArF';

$search = [];
$replace = [];

$pieces = explode("\n", $input);

/*shuffle_assoc($pieces);

foreach ($pieces as $line) {
    list($key, $value) = explode(' => ', $line);
    $search[] = $key;
    $replace[] = $value;
}*/

$minimum = 5000;

do {

    $word = $medicine;
    $status = false;

    while ($status === false) {

        $finals = ['HF', 'NAl', 'OMg'];
        //$finals = ['NAl', 'OMg'];
        $final = $finals[array_rand($finals)];
        $steps = [];

        print 'TRYING TO REACH ' . $final . PHP_EOL . '-----------------------------------------------' . PHP_EOL;

        $j = 0;

        while ($word != $final) {

            shuffle_assoc($pieces);
            $search = [];
            $replace = [];

            foreach ($pieces as $line) {
                list($key, $value) = explode(' => ', $line);
                $search[] = $key;
                $replace[] = $value;
            }

            $i = 0;
            $previous = $word;
            foreach ($replace as $segment) {
                if (strpos($word, $segment) !== false) {
                    $offset = 0;
                    //$word = preg_replace('/' . $segment . '/', $search[$i], $word, 1);
                    $positions = [];
                    while (strpos($word, $segment, $offset) !== false) {
                        $position = strpos($word, $segment, $offset);
                        $offset = $position + 1;
                        $positions[] = $position;
                    }

                    $position = $positions[array_rand($positions)];

                    $word = substr_replace($word, $search[$i], $position, strlen($segment));

                    print $word . PHP_EOL;

                    $j++;
                    $steps[] = [$search[$i] => $replace[$i]];

                    break;
                }

                $i++;
            }

            if ($word == $previous) {
                // Nothing happened, bust it
                print 'FAILURE' . PHP_EOL;
                break;
            } elseif ($word == $final) {
                $steps[] = ['e' => $final];
                $status = true;
                print $j . ' replacements' . PHP_EOL;
                $minimum = min($minimum, $j);
                if ($j == $minimum) {
                    $lowestSteps = $steps;
                }
            }
        }

        $word = $medicine;
    }

    print ' ==== Lowest so far: ' . $minimum . ' ==== ' . PHP_EOL;
    //print_r($lowestSteps);
    sleep(1);
} while ($minimum > 20);

