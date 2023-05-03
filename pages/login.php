<?php
require_once('./connection/connectionString.php');
require_once('./classes/AccountInfo.php');

$userID = AccountInfo::getUserID();
if ($userID !== null) {
    header("Location: " . TEMPLATE . '403.php');
    var_dump($userID);
    exit();
}

if (isset($_POST['submit'])) {
    $email = strip_tags($_POST['email']);
    $password = strip_tags($_POST['password']);

    $stmt = $conn->prepare(
        "CALL loginGetEmail(:email)");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch();


    if ($user) {
        $stmt = $conn->prepare(
            "CALL loginGetPass(:userID)");
        $stmt->bindParam(':userID', $user['userID']);
        $stmt->execute();
        $passwordData = $stmt->fetch();

        if (password_verify($password, $passwordData['password_hash'])) {
            session_start();
            $_SESSION['userID'] = $user['userID'];
            $_SESSION['userName'] = $user['userName'];
            $_SESSION['role'] = $user['role'];
            $redirect = isset($_GET['id']) ? 'index.php?page=event&id=' . $_GET['id'] : 'index.php';
            header('Location: ' . $redirect);
            exit();
        } else {
            echo '<div class="error" style="color: red;"><h3>Incorrect password.</h3></div>';
        }
    } else {
        echo '<div class="error" style="color: red;"><h3>No user found with the given email.</h3></div>';
    }
}
?>

<main>
    <form class="form" method="post">
        <div class="title">Login</div>
        <div class="input-container ic1">
            <input id="email" name="email" class="input" type="email" placeholder=" " required />
            <div class="cut cut-short"></div>
            <label for="email" class="placeholder">Email*</label>
        </div>
        <div class="input-container ic2">
            <input id="password" name="password" class="input" type="password" placeholder=" " required />
            <div class="cut"></div>
            <label for="password" class="placeholder">Password*</label>
        </div>
        <button type="submit" name="submit" class="submit">Login</button>
    </form>
</main>