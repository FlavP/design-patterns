<?php
require_once('Queue.php');
require_once('IMDBGenresScrapingCommand.php');

$queue = Queue::get();

if (!$queue->isEmpty())
    $queue->addCommand(new IMDBGenresScrapingCommand());

$queue->work();
