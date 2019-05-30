<?php

/**
 * Base Command
 * Interface Command
 */
interface Command
{
    public function execute();
    public function getId();
    public function getStatus();
}