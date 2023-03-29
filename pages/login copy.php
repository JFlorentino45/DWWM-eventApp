<?php
    // Include database connection file
    include('../connection/connectionString.php');

    // Check if the form has been submitted
    if(isset($_POST['submit'])) {
        // Get the email from the form
        $email = $_POST['email'];

        // Query the user table for the email
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        // Check if a user was found with the given email
        if($user) {
            // Start a new session and store user information in session variables
            session_start();
            $_SESSION['userID'] = $user['userID'];
            $_SESSION['userName'] = $user['userName'];
            // Add any other user information you want to store in session variables here

            // Redirect the user to the home page
            header('Location: ../index.php');
            exit();
        } else {
            // Display an error message if no user was found with the given email
            echo "No user found with the given email.";
        }
    }
?>

<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form method="post">
        <label>Email:</label>
        <input type="email" name="email" required>
        <input type="submit" name="submit" value="Login">
    </form>
</body>