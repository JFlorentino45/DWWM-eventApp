<?php
    session_start(); // Start the session
    session_destroy(); // Destroy all data registered to the session
    header("Location: ../index.php"); // Redirect to Home page
    exit(); // Stop script from running further
?>