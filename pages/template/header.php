<header>
    <nav>
    <ul>
        <li>
            <a href="#">Home</a>
        </li>
        <li>
            <a href="./pages/myEvents.php">My Events</a>
        </li>
        <li>
            <a href="./pages/newUser.php">New User</a>
        </li>
        <?php
            session_start();
            $loggedIn = isset($_SESSION['userID']); // Check if user is logged in

            if($loggedIn) {
                // Get user information from session variables
                $userName = $_SESSION['userName'];
                // Add any other user information you want to display here

                // Display the user's name in the nav bar
                echo '<li><a href="#">' . $userName .'</a></li>';
                echo '<li><a href="./pages/logout.php">Logout</a></li>';
            } else {
                // Display the Login tab if the user is not logged in
                echo '<li><a href="./pages/login.php">Login</a></li>';
            }
        ?>
    </ul>
    </nav>
</header>