<?php
require_once ("./src/connection.php");

$allUsers = User::GetAllUsers();

foreach($allUsers as $userToShow)
{
    echo("<a href='showUser.php?userId={$userToShow->getId()}'>{$userToShow->getName()}</a><br>");
}