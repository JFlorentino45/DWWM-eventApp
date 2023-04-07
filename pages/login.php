<?php
require_once('./connection/connectionString.php');
require_once('./classes/AccountInfo.php');

$userID = getUserID();
if($userID !== null){
    header("Location: ". TEMPLATE . '403.php');
    var_dump($userID);
    exit();
}

if(isset($_POST['submit'])) {
    $email = strip_tags($_POST['email']);
    $password = strip_tags($_POST['password']);

        $stmt = $conn->prepare("CALL loginGetEmail(:email)");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();
    

        if($user) {
            $stmt = $conn->prepare("CALL loginGetPass(:userID)");
            $stmt->bindParam(':userID', $user['userID']);
            $stmt->execute();
            $passwordData = $stmt->fetch();

            if(password_verify($password, $passwordData['password_hash'])) {
                session_start();
                $_SESSION['userID'] = $user['userID'];
                $_SESSION['userName'] = $user['userName'];
                $_SESSION['role'] = $user['role'];
                $redirect = isset($_GET['id']) ? 'index.php?page=event&id=' . $_GET['id'] : 'index.php';
                header('Location: ' . $redirect);
                exit();
            } else {
                echo "Incorrect password.";
            }
        } else {
            echo "No user found with the given email.";
        }
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
