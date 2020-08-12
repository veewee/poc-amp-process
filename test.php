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
        $process = new Symfony\Component\Process\Process(['php', 'process.php', $url]);
        return $process->mustRun()->getOutput();
    }));

    var_dump($responses);

} catch (\Amp\MultiReasonException $e) {
    printErrors($e);
}
