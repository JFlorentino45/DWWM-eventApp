<?php
// Include database connection file
include('./connection/connectionString.php');
require_once('./classes/AccountInfo.php');
$userID = getUserID();
if($userID == ''){
    // Check if the form has been submitted
    if(isset($_POST['submit'])) {
        // Get the email and password from the form
        $email = $_POST['email'];
        $password = $_POST['password'];
    
        // Query the user table for the email
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
    
        // Check if a user was found with the given email
        if($user) {
            // Query the password table for the user's password hash
            $stmt = $conn->prepare("SELECT password_hash FROM password WHERE userID = :userID");
            $stmt->execute(['userID' => $user['userID']]);
            $passwordData = $stmt->fetch();
    
            // Verify the submitted password using the retrieved hash
            if(password_verify($password, $passwordData['password_hash'])) {
                // Start a new session and store user information in session variables
                session_start();
                $_SESSION['userID'] = $user['userID'];
                $_SESSION['userName'] = $user['userName'];
                $_SESSION['role'] = $user['role'];
                // Add any other user information you want to store in session variables here
                if(isset($_GET['id'])){
                    header('Location: ./index.php?page=event&id=' . $_GET['id']);
                } else{
                    header('Location: ./index.php');
                    exit();
                }
            } else {
                // Display an error message if the password is incorrect
                echo "Incorrect password.";
            }
        } else {
            // Display an error message if no user was found with the given email
            echo "No user found with the given email.";
        }
    }
} else{
    header("Location: ". TEMPLATE . '404.php');
}
?>
<main>
    <h1>Login</h1>
    <form method="post">
        <label>Email:</label>
        <input type="email" name="email" required>
        <label>Password:</label>
        <input type="password" name="password" required>
        <input type="submit" name="submit" value="Login">
    </form>
</main>
