<?php 
include('./connection/connectionString.php');
require_once('./classes/AccountInfo.php');
$control = getUserID();
if($control == ''){
    header("Location: ". TEMPLATE . '404.php');
} else{
    $role = getRole();
    $userID = $_GET['id'];
    if($role == 'admin' || $userID == $control){
        if(isset($_POST['submit'])){
            if($role == 'admin'){
                $newPassword = $_POST['newPassword'];
                $passwordCheck = $_POST['passwordCheck'];
                if($newPassword == $passwordCheck){
                    $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare(
                        'UPDATE password 
                        SET password_hash = :password_hash
                        WHERE userID = :userID');
                    $stmt->bindParam(':userID', $userID);
                    $stmt->bindParam(':password_hash', $hashed_password);
                    $stmt->execute();
                    echo "Password Reset!";
                } else{
                    echo "New Passwords do not match";
                }
            } else{
            $password = $_POST['oldPassword'];

            $stmt = $conn->prepare("SELECT password_hash FROM password WHERE userID = :userID");
            $stmt->execute([':userID' => $userID]);
            $passwordData = $stmt->fetch();

            if(password_verify($password, $passwordData['password_hash']) || $role == 'admin') {
                $newPassword = $_POST['newPassword'];
                $passwordCheck = $_POST['passwordCheck'];
                if($newPassword == $passwordCheck){
                    $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare(
                        'UPDATE password 
                        SET password_hash = :password_hash
                        WHERE userID = :userID');
                    $stmt->bindParam(':userID', $userID);
                    $stmt->bindParam(':password_hash', $hashed_password);
                    $stmt->execute();
                    echo "Password Reset!";
                } else{
                    echo "New Passwords do not match";
                }

            } else{
                echo "Incorrect Current Password!";
            }
        }

        }

    } else{
        header("Location: ". TEMPLATE . '404.php');
    }
}
?>

<main>
    <h1>Reset Password</h1>
    <form method="POST">
        <?php
        if($role != 'admin'){
        ?>
            <label>Current Password:</label>
            <input type="password" name="oldPassword" required>
        <?php
        }
        ?>
        <label>New Password:</label>
        <input type="password" name="newPassword" required>
        <label>Confirm Password:</label>
        <input type="password" name="passwordCheck" required>
        <label>Are you sure?</label>
        <input type="submit" name="submit" value="Yes">
    </form>
    <a href="index.php"><button>Cancel</button></a>
</main>