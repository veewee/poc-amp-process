<?php

if (!$url ?? null) {
    throw new \Exception('no url ...');
}

return \Amp\call(function () use ($url) {
    $process = new Symfony\Component\Process\Process(['php', '-r', 'echo "'.$url.'";']);
    return $process->mustRun()->getOutput();
});
