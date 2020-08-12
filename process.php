<?php

if (!$url = $_SERVER['argv'][1] ?? null) {
    exit;
}

echo $url;
