<?php

class SlackApi
{
    // ca un api frumos ce este, are nevoie de informatii de login
    private $user;
    private $apiKey;

    // are un constructor care pregateste obiectul de login
    public function __construct($user, $apiKey){
        $this->user = $user;
        $this->apiKey = $apiKey;
    }

    // are o functie de login
    public function authenticate(){
        echo "Logged in as " . $this->user . "\n";
    }

    // are o functie de trimitere a mesajelor pe care vrem sa o folosim
    // pentru a trimite Notificari prin slack
    public function sendMessage($chatId, $message){
        echo "Posted the following message into the " . $chatId . " chat: " . $message . "\n";
    }
}