<?php
require_once("./src/connection.php");

if (isset($_SESSION['userId']) != true)
{
    header("Location: login.php");
}

$id = $_GET['id'];

$tweetToDelete = Tweet::ShowTweetById($id);

echo("{$tweetToDelete->getTweetBody()}<br>");

echo("
        <strong>Delete tweet:</strong>
        <p>To confirm that you want to delete this tweet, type DELETE</p>
        <form action='deleteTweet.php?id=$id' method='post'>
            <input type='text' name='del_text'>
            <input type='submit'>
        </form>
        ");
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{

    if (isset($_POST['del_text']) == "DELETE")
    {
        $tweetToDelete-> removeTweet();
        header("Location: showUser.php");
    }
    else
    {
        echo("You are still not sure. Type DELETE when you ready");
    }
}