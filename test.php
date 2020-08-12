<?php

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/MultiPromise.php';

use Amp\LazyPromise;
use Amp\Parallel\Worker\DefaultPool;
use function Amp\ParallelFunctions\parallel;
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
    $pool = new DefaultPool(32);
    $responses = wait(
        \Amp\call(function () {
            [$errors, $results] = yield MultiPromise::cancelable(
                [
                    new LazyPromise(function () {
                        return parallel(function () {
                            $url = 'https://google.com/';
                            return require 'process.php';
                        })();
                    }),
                    new LazyPromise(function () {
                        return parallel(function () {
                            $url = 'https://github.com/';
                            return require 'process.php';
                        })();
                    }),
                    new LazyPromise(function () {
                        return parallel(function () {
                            $url = 'https://stackoverflow.com/';
                            return require 'process.php';
                        })();
                    }),
                ],
                function () {
                    return false;
                }
            );

            if (count($errors)) {

                foreach ($errors as $error) {
                    printErrors($error);
                }
                exit(1);
            }

            return $results;
        })
    );

    var_dump($responses);

} catch (\Amp\MultiReasonException $e) {
    printErrors($e);
}
