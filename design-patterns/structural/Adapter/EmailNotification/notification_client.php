<?php
require_once('EmailNotification.php');
require_once('SlackApi.php');
require_once('SlackNotificationAdapter.php');

function clientCode(Notification $notification){
    echo $notification->send("Website down", "Call the admin");
}

echo "\nUsing the email notification interface\n";
$notification = new EmailNotification('admin@example.com');
clientCode($notification);

echo "\nUsing the slack notification adapter\n";
$slackApi = new SlackApi('dubiadmin', 'secret_token');
$slackAdapterNotification = new SlackNotificationAdapter($slackApi, "Our Devs Chat");
clientCode($slackAdapterNotification);