<?php
require_once('./classes/AccountInfo.php');

session_start();

function getNavigationItems()
{
    $loggedIn = isset($_SESSION['userID']);
    $role = strip_tags(htmlspecialchars(AccountInfo::getRole()));
    if ($loggedIn && $role === 'admin') {
        return '
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php?page=users">Users</a></li>
            <li><a href="index.php?page=myEventsO">Events</a></li>
            <li><a href="index.php?page=venues">Venues</a></li>
            <li class="right"><a href="index.php?page=logout">Logout</a></li>';
    } elseif ($loggedIn && $role === 'organiser') {
        return '
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php?page=newEvent">Create Event</a></li>
            <li><a href="index.php?page=myEventsO">My Events</a></li>
            <li class="right"><a href="index.php?page=logout">Logout</a></li>
            <li class="right"><a href="index.php?page=profile">Profile</a></li>';
    } elseif ($loggedIn && $role === 'participant') {
        return '
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php?page=myEventsP">My Events</a></li>
            <li class="right"><a href="index.php?page=logout">Logout</a></li>
            <li class="right"><a href="index.php?page=profile">Profile</a></li>';
    } else {
        return '
            <li><a href="index.php">Home</a></li>
            <li class="right"><a href="index.php?page=login">Login</a></li>
            <li class="right"><a href="index.php?page=newUser">Create Account</a></li>';
    }
}