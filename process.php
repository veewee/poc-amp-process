<?php

if (!$url ?? null) {
    throw new \Exception('no url ...');
}

return new \Amp\Success($url);


//$process = new Symfony\Component\Process\Process(['php', '-r', 'sleep(30); echo "'.$url.'";']);
//echo $process->mustRun()->getOutput();
