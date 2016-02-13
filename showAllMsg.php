<?php
require_once("./src/connection.php");

if (isset($_SESSION['userId']) != true)
{
    header("Location: login.php");
}
$userId = $_SESSION['userId'];
$userToShow = User::GetUserById($userId);


echo("<h1>{$userToShow->getName()}</h1>");
echo("<strong>Messages</strong><br>");

foreach($userToShow->loadAllReceivedMsg() as $msg)
{
    $sender = User::GetUserById($msg->getIdSent());
    echo("Sent by {$sender->getName()}<br>");
    $lead = substr($msg->getBodyMsg(), 0, 30);
    if($msg->getReadMsg() == 1)
    {
        echo("<a href='showMsg.php?id={$msg->getId()}'><strong>$lead ...</strong></a><br>");
    }
    else
    {
        echo("<a href='showMsg.php?id={$msg->getId()}'>$lead ...</a><br>");
    }
    echo("{$msg->getDateMsg()}<br>");
}

echo("<strong>Sent messages</strong><br>");

foreach($userToShow->loadAllSentMsg() as $msg)
{
    $receiver = User::GetUserById($msg->getIdReceived());
    echo("Received by {$receiver->getName()}<br>");
    $lead = substr($msg->getBodyMsg(), 0, 30);
    if($msg->getReadMsg() == 1)
    {
        echo("<a href='showMsg.php?id={$msg->getId()}'><strong>$lead ...</strong></a><br>");
    }
    else
    {
        echo("<a href='showMsg.php?id={$msg->getId()}'>$lead ...</a><br>");
    }
    echo("{$msg->getDateMsg()}<br>");
}

