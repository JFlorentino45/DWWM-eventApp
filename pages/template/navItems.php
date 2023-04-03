<?php
session_start();
function getNavigationItems() {
    $loggedIn = isset($_SESSION['userID']);
    $role = isset($_SESSION['role']);
    $userName = isset($_SESSION['userName']);
    if($loggedIn && $_SESSION['role'] === 'admin') {
        return '
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php?page=users">Users</a></li>
            <li><a href="index.php?page=myEventsO">Events</a></li>
            <li><a href="index.php?page=venues">Venues</a></li>
            <li><a href="index.php?page=logout">Logout</a></li>';
    }
    elseif($loggedIn && $_SESSION['role'] === 'organiser') {
        return '
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php?page=createEvent">Create Event</a></li>
            <li><a href="index.php?page=myEventsO">My Events</a></li>
            <li><a href="index.php?page=logout">Logout</a></li>';
    }
    elseif($loggedIn && $_SESSION['role'] === 'participant') {
        return '
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php?page=myEventsP">My Events</a></li>
            <li><a href="index.php?page=logout">Logout</a></li>';
    }
    else {
        return '
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php?page=login">Login</a></li>
            <li><a href="index.php?page=newUser">Create account</a></li>';
    }
}
?>