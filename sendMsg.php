<?php
require_once("./src/connection.php");

if (isset($_SESSION['userId']) != true)
{
    header("Location: login.php");
}
$userIdReceiver = $_GET['id'];
$userToShow = User::GetUserById($userIdReceiver);

echo("<strong>Send message</strong><br>");
echo("<strong>To {$userToShow->getName()}</strong><br>");

echo("
    <form method='POST'>
    <textarea name='msg' cols='40' rows='10'></textarea>
    <input type='submit' value='Send'>
    </form>");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newBodyMsg = $_POST['msg'];
    $newIdSent = $_SESSION['userId'];
    $newIdReceived = $_GET['id'];
    Message::CreateMsg($newIdSent, $newIdReceived, $newBodyMsg);
    header("Location: showAllMsg.php");
}
