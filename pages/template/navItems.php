<?php
session_start();
function getNavigationItems() {
    $loggedIn = isset($_SESSION['userID']);
    $role = isset($_SESSION['role']);
    $userName = isset($_SESSION['userName']);
    if($loggedIn && $_SESSION['role'] === 'admin') {
        return '
            <li><a href="#">Home</a></li>
            <li><a href="./pages/users.php">Users</a></li>
            <li><a href="./pages/logout.php">Logout</a></li>';
    }
    elseif($loggedIn && $_SESSION['role'] === 'organiser') {
        return '
            <li><a href="#">Home</a></li>
            <li><a href="./pages/createEvent.php">Create Event</a></li>
            <li><a href="./pages/logout.php">Logout</a></li>';
    }
    elseif($loggedIn && $_SESSION['role'] === 'participant') {
        return '
            <li><a href="#">Home</a></li>
            <li><a href="./pages/myEvents.php?id='. $_SESSION['userID'] . '">My Events</a></li>
            <li><a href="./pages/logout.php">Logout</a></li>';
    }
    else {
        return '
            <li><a href="#">Home</a></li>
            <li><a href="./pages/login.php">Login</a></li>
            <li><a href="./pages/newUser.php">Create account</a></li>
            <li><a href="./pages/logout.php">Logout</a></li>';
    }
}
?>