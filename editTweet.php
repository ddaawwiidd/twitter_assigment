<?php
//all good
require_once("./src/connection.php");

if (isset($_SESSION['userId']) != true)
{
    header("Location: login.php");
}

$id = $_GET['id'];

$tweetToEdit = Tweet::ShowTweetById($id);

echo("{$tweetToEdit->getTweetBody()}<br>");
echo("
        <strong>Edit tweet:</strong>
        <form action='editTweet.php?id=$id' method='post'>
            <input type='text' name='edit_text'>
            <input type='submit'>
        </form>
        ");
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{

    if (isset($_POST['edit_text']) && strlen(trim($_POST['edit_text'])) > 0)
    {
        $newTweetBody = $_POST['edit_text'];
        $tweetToEdit-> updateTweet($newTweetBody);
        header("Location: showUser.php");
    }
    else
    {
        echo("We couldn't save your tweet");
    }
}