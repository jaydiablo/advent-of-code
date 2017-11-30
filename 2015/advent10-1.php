<?php

$input = '1113222113';

//$input = '1211';

function convert($in) {
    preg_match_all('|([0-9])\1*|', $in, $matches);

    $new = '';

    foreach ($matches[0] as $match) {
        $new .= strlen($match) . substr($match, 0, 1);
    }

    return $new;
}

for ($i = 0; $i < 50; $i++) {
    //echo strlen($input);
    $input = convert($input);
}

echo strlen($input);
