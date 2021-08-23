<?php

namespace Libot;

class Logger
{
    private $dir;

    public function __construct($dir)
    {
        $this->dir = $dir;
    }

    public function execute($message)
    {
        $time = date('d.m.Y H:i:s', time());
        error_log("$time: $message" . PHP_EOL, 3, $this->dir);
    }
}