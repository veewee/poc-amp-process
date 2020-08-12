<?php

require_once __DIR__.'/vendor/autoload.php';

if (!$url = $_SERVER['argv'][1] ?? null) {
    exit;
}


$process = new Symfony\Component\Process\Process(['php', '-r', 'echo "'.$url.'";']);
echo $process->mustRun()->getOutput();
