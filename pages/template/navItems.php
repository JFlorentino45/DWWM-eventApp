
<?php
require_once('./classes/AccountInfo.php');
session_start();
function getNavigationItems() {
    $loggedIn = isset($_SESSION['userID']);
    $role = getRole();
    if($loggedIn && $role === 'admin') {
        return '
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php?page=newUser">Create User</a></li>
            <li><a href="index.php?page=users">Users</a></li>
            <li><a href="index.php?page=newEvent">Create Event</a></li>
            <li><a href="index.php?page=myEventsO">Events</a></li>
            <li><a href="index.php?page=venues">Venues</a></li>
            <li><a href="index.php?page=logout">Logout</a></li>';
    }
    elseif($loggedIn && $role === 'organiser') {
        return '
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php?page=newEvent">Create Event</a></li>
            <li><a href="index.php?page=myEventsO">My Events</a></li>
            <li><a href="index.php?page=profile">Profile</a></li>
            <li><a href="index.php?page=logout">Logout</a></li>';
    }
    elseif($loggedIn && $role === 'participant') {
        return '
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php?page=myEventsP">My Events</a></li>
            <li><a href="index.php?page=profile">Profile</a></li>
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