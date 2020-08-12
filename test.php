<?php

require_once __DIR__.'/vendor/autoload.php';

use function Amp\ParallelFunctions\parallelMap;
use function Amp\Promise\wait;

function printErrors(\Throwable $e) {
    if ($e instanceof \Amp\MultiReasonException) {
        foreach ($e->getReasons() as $reason) {
            printErrors($reason);
        }
    }

    echo $e;
}


try {
    $responses = wait(parallelMap([
        'https://google.com/',
        'https://github.com/',
        'https://stackoverflow.com/',
    ], function ($url) {
        return wait(require 'process.php');
    }));

    var_dump($responses);

} catch (\Amp\MultiReasonException $e) {
    printErrors($e);
}
