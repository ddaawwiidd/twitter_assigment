<?php
require_once("./src/connection.php");

if (isset($_SESSION['userId']) != true)
{
    header("Location: login.php");
}

$msgId = $_GET['id'];
$msgToShow = Message::LoadMsgById($msgId);
$receiver = User::GetUserById($msgToShow->getIdReceived());
$sender = User::GetUserById($msgToShow->getIdSent());
echo("<strong>{$sender->getName()}</strong> sent it to <strong>{$receiver->getName()}</strong><br>");
echo("{$msgToShow->getDateMsg()}");
echo("<p>{$msgToShow->getBodyMsg()}</p>");

echo("
    <form method='POST'>
    <textarea name='msg' cols='40' rows='4'></textarea>
    <input type='submit' value='Reply'>
    </form>");
$receiverId = $receiver->getId();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newBodyMsg = $_POST['msg'];
    $newIdSent = $_SESSION['userId'];
    $newIdReceived = $receiverId;
    Message::CreateMsg($newIdSent, $newIdReceived, $newBodyMsg);
    header("Location: showAllMsg.php");
}

echo("<a href='showAllMsg.php'>Go back</a><br>");
