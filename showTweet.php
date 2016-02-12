<?php
require_once("./src/connection.php");

if (isset($_SESSION['userId']) != true)
{
    header("Location: login.php");
}


$id = $_GET['id'];
$tweetToShow = Tweet::ShowTweetById($id);
$userId = $_SESSION['userId'];
$userToShow = User::GetUserById($userId);

echo("<h1>{$userToShow->getName()}</h1>");
echo("{$tweetToShow->getTweetBody()}<br>");
echo("{$tweetToShow->getPostDate()}<br>");
$commentsNumber = count($tweetToShow->getAllComments());
echo("Comments $commentsNumber <br>");

echo("
        <h3>New comment:</h3>
        <form action='showTweet.php?id=$id' method='post'>
            <input type='text' name='comment_text'>
            <input type='submit'>
        </form>
        ");

foreach($tweetToShow->getAllComments() as $comment)
{

    $commentOwner = User::GetUserById($comment->getIdUser());
    echo("<em>{$commentOwner->getName()}</em><br>");
    echo("{$comment->getCommentBody()}<br>");
    echo("{$comment->getCommentDate()}<br>");

}


if ($_SERVER['REQUEST_METHOD'] === 'POST')
{

    if (isset($_POST['comment_text']) && strlen(trim($_POST['comment_text'])) > 0)
    {
        $newIdUser = $_SESSION['userId'];
        $newIdTweet = $_GET['id'];
        $newCommentBody = $_POST['comment_text'];
        $comment = Comment::CreateComment($newIdUser, $newIdTweet, $newCommentBody);
        header("Location: showUser.php ");


    }
    else
    {
        echo("We couldn't save your comment");
    }
}
