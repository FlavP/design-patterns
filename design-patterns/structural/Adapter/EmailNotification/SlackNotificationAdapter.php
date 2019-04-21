<?php
require_once('Notification.php');
require_once('SlackApi.php');

class SlackNotificationAdapter implements Notification
{
    private $slack;
    private $chatId;

    public function __construct(SlackApi $slack, $chatId)
    {
        $this->slack = $slack;
        $this->chatId = $chatId;
    }

    /**
     * Acum adaptam metoda vietii folosind metoda lui nenea slack
     */
    public function send($title, $message)
    {
        $slackMessage = "#" . $title . "# " . strip_tags($message);
        // trebuie sa autentificam api-ul
        $this->slack->authenticate();
        $this->slack->sendMessage($this->chatId, $slackMessage);
    }
}