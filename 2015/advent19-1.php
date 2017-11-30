<?php

ini_set('memory_limit', -1);

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

/*$input = 'H => HO
H => OH
O => HH';

$medicine = 'HOHOHO';
*/

$molecules = [];
$search = [];
$replace = [];

foreach (explode("\n", $input) as $line) {
    list($key, $value) = explode(' => ', $line);
    $search[] = $key;
    $replace[] = $value;
}

for ($i = 0, $count = count($search); $i < $count; $i++) {
    $offset = 0;
    while (strpos($medicine, $search[$i], $offset) !== false) {
        $position = strpos($medicine, $search[$i], $offset);
        print 'Found ' . $search[$i] . ' in string at position ' . $position .PHP_EOL;
        $molecules[] = substr_replace($medicine, $replace[$i], $position, strlen($search[$i]));
        $offset = $position + 1;
        print $molecules[count($molecules) - 1] . PHP_EOL;
    }
}

//print_r($molecules);

print count($molecules) . PHP_EOL;

$molecules = array_unique($molecules);

//print_r($molecules);

print count($molecules) . PHP_EOL;