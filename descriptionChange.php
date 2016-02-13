<?php
require_once("./src/connection.php");

if (isset($_SESSION['userId']) != true)
{
    header("Location: login.php");
}

$user = User::GetUserById($_SESSION['userId']);

echo("
    <form method='POST'>Edit your description:
    <p>
        <label>
            <textarea name='description' rows='4'>Type your new description</textarea>
        </label>
    </p>
    <input type='submit' value='change'>
    </form>");

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $newDescription = $_POST['description'];
    $user->changeDescription($newDescription);
    header("Location: showUser.php");
}
