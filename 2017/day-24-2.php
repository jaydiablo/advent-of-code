<?php

$input = '0/2
2/2
2/3
3/4
3/5
0/1
10/1
9/10';

$input = '48/5
25/10
35/49
34/41
35/35
47/35
34/46
47/23
28/8
27/21
40/11
22/50
48/42
38/17
50/33
13/13
22/33
17/29
50/0
20/47
28/0
42/4
46/22
19/35
17/22
33/37
47/7
35/20
8/36
24/34
6/7
7/43
45/37
21/31
37/26
16/5
11/14
7/23
2/23
3/25
20/20
18/20
19/34
25/46
41/24
0/33
3/7
49/38
47/22
44/15
24/21
10/35
6/21
14/50';

$max = 0;
$port = 0;

$components = [];
$ports = [];
$bridges = [];

$lines = explode("\n", $input);

foreach ($lines as $line) {
    [$port1, $port2] = explode('/', $line);

    $components[] = [
        'port1' => $port1,
        'port2' => $port2,
        'sum' =>  ((int) $port1 + (int) $port2),
    ];

    $i = count($components) - 1;

    if (!isset($ports[$port1])) {
        $ports[$port1] = [];
    }
    $ports[$port1][] = $i;

    if (!isset($ports[$port2])) {
        $ports[$port2] = [];
    }
    $ports[$port2][] = $i;
}

$bridgeLookup = [];

function attach(int $port, array &$bridges, $bridge = []) {
    global $components, $ports, $bridgeLookup;

    $prevBridge = $bridge;

    foreach ($ports as $num => $componentIds) {
        if ($num === $port) {
            foreach ($componentIds as $componentId) {
                if (!in_array($componentId, $bridge)) {
                    $bridge[] = $componentId;

                    // Store this bridge
                    sort($bridge);
                    $bridgeKey = implode(',', $bridge);
                    if (!isset($bridgeLookup[$bridgeKey])) {
                        $bridges[] = $bridge;
                        $bridgeLookup[$bridgeKey] = 1;
                    }

                    $component = $components[$componentId];

                    if ($component['port1'] == $port) {
                        attach($component['port2'], $bridges, $bridge);
                    } else {
                        attach($component['port1'], $bridges, $bridge);
                    }
                }

                $bridge = $prevBridge;
            }
        }
    }

}

$maxLen = 0;

attach($port, $bridges);

usort($bridges, function ($a, $b) use ($components) {
    $countA = count($a);
    $countB = count($b);
    if ($countA === $countB) {
        $aStrength = 0;
        foreach ($a as $componentId) {
            $component = $components[$componentId];
            $aStrength += $component['sum'];
        }
        $bStrength = 0;
        foreach ($b as $componentId) {
            $component = $components[$componentId];
            $bStrength += $component['sum'];
        }
        return (int) $aStrength < $bStrength;
    } else {
        return (int) $countA < $countB;
    }
});

$longest = $bridges[0];

$strength = 0;

foreach ($longest as $componentId) {
    $component = $components[$componentId];

    $strength += $component['sum'];
}

print $strength . PHP_EOL;
