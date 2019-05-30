<?php


interface Notification
{
    public function send($title, $message);
}