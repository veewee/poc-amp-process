<?php

require_once __DIR__.'/vendor/autoload.php';

use function Amp\ParallelFunctions\parallelMap;
use function Amp\Promise\wait;

$responses = wait(parallelMap([
    'https://google.com/',
    'https://github.com/',
    'https://stackoverflow.com/',
], function ($url) {
    return $url;
}));

var_dump($responses);
