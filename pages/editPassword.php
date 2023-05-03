<?php
require_once('./connection/connectionString.php');
require_once('./classes/CheckUID.php');
require_once('./classes/AccountInfo.php');

$control = strip_tags(htmlspecialchars(AccountInfo::getUserID()));

if ($control == '') {
    header("Location: " . TEMPLATE . '403.php');
} else {
    $role = strip_tags(htmlspecialchars(AccountInfo::getRole()));
    $userID = strip_tags(htmlspecialchars($_GET['id']));
    CheckUID::GetuID($userID, $conn);
    if ($role == 'admin' || $userID == $control) {
        if (isset($_POST['submit'])) {
            if ($role == 'admin') {
                $newPassword = strip_tags(htmlspecialchars($_POST['newPassword']));
                $passwordCheck = strip_tags(htmlspecialchars($_POST['passwordCheck']));
                if ($newPassword == $passwordCheck) {
                    $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare('CALL editPAdmin(:password_hash, :userID)');
                    $stmt->bindParam(':password_hash', $hashed_password);
                    $stmt->bindParam(':userID', $userID);
                    $stmt->execute();
                    echo "Password Reset!";
                } else {
                    echo "New Passwords do not match";
                }
            } else {
                $password = strip_tags(htmlspecialchars($_POST['oldPassword']));

                $stmt = $conn->prepare('CALL editPGet(:userID)');
                $stmt->bindParam(':userID', $userID);
                $stmt->execute();
                $passwordData = $stmt->fetch();

                if (password_verify($password, $passwordData['password_hash']) || $role == 'admin') {
                    $newPassword = strip_tags(htmlspecialchars($_POST['newPassword']));
                    $passwordCheck = strip_tags(htmlspecialchars($_POST['passwordCheck']));
                    if ($newPassword == $passwordCheck) {
                        $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
                        $stmt = $conn->prepare('CALL editPUser(:password_hash, :userID)');
                        $stmt->bindParam(':userID', $userID);
                        $stmt->bindParam(':password_hash', $hashed_password);
                        $stmt->execute();
                        echo "Password Reset!";
                    } else {
                        echo "Passwords do not match";
                    }
                } else {
                    echo "Incorrect Current Password!";
                }
            }
        }
    } else {
        header("Location: " . TEMPLATE . '403.php');
    }
}
?>

<main>
    <form class='form' method="POST" onsubmit='return confirm("Are you sure?")'>
        <div class="title">Reset Password</div>
        <?php
        if ($role != 'admin') {
        ?>
            <style>
                .form {
                    height: 550px;
                }
            </style>
            <div class="input-container ic1">
                <input id='oldPassword' name='oldPassword' class='input' type='password' placeholder=" " required />
                <div class='cut'></div>
                <label for='oldPassword' class='placeholder'>Current Password</label>
            </div>
        <?php
        }
        ?>
        <div class="input-container ic1">
            <input id='newPassword' name='newPassword' class='input' type='password' placeholder=" " required />
            <div class='cut cut-short'></div>
            <label for='newPassword' class='placeholder'>New Password</label>
        </div>
        <div class="input-container ic2">
            <input id='passwordCheck' name='passwordCheck' class='input' type='password' placeholder=" " required />
            <div class='cut'></div>
            <label for='passwordCheck' class='placeholder'>Confirm Password</label>
        </div>
        <button type="submit" name="submit" class='submit'>Change Password</button>
        <a href="index.php"><button class='submitR' type='button'>Cancel</button></a>
    </form>
</main>