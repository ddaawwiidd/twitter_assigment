<?php
require_once ("./src/connection.php");

if(isset($_GET["userId"])){
    $userId = $_GET["userId"];
}
else
{
    $userId = $_SESSION['userId'];
}

$userId = $_GET["userId"];
$userToShow = User::GetUserById($userId);

if($userToShow != false)
{
    echo("<h1>{$userToShow->getName()}</h1>");

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
        echo("Shows tweets...");
    }
}
else
{
    echo("User doesn't exist.");
}