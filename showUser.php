<?php
require_once ("./src/connection.php");

if(isset($_SESSION['userId']) != true)
{
    header("location: login.php");
}

if(isset($_GET["userId"])){
    $userId = $_GET["userId"];
}
else
{
    $userId = $_SESSION['userId'];
}

$userToShow = User::GetUserById($userId);

if($userToShow != false)
{
    echo("<h1>{$userToShow->getName()}</h1>");
    echo("{$userToShow->getDescription()}<br>");

    if($userToShow->getId() === $_SESSION['userId'])
    {
        echo("
        <h3>New tweet:</h3>
        <form action='showUser.php' method='post'>
            <input type='text' name='tweet_text'>
            <input type='submit'>
        </form>
        ");
    }

    foreach($userToShow->loadAllTweets() as $tweet)
    {
        echo("{$tweet->getTweetBody()}<br>");
    }
}
else
{
    echo("User doesn't exist.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{

    if(isset($_POST['tweet_text']) && strlen(trim($_POST['tweet_text'])) > 0)
    {
        $idUser = $_SESSION['userId'];
        $tweetBody = $_POST['tweet_text'];
        $tweet = Tweet::CreateTweet($idUser, $tweetBody);
        header("location: showUser.php");

    }
    else
    {
        echo("We couldn't save your tweet");
    }
}