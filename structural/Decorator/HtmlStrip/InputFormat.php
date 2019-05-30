<?php

/**
 * The Component interface declares a function that must
 * be implemented by all concrete components and decorators
 * Interface InputFormat
 */
interface InputFormat
{
    public function formatText($text);
}