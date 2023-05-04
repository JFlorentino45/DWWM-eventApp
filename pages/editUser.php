<?php
require_once('./connection/connectionString.php');
require_once('./classes/AccountInfo.php');
require_once('./classes/CheckUID.php');

$control = strip_tags(htmlspecialchars(AccountInfo::getUserID()));

if ($control == '') {
    header("Location: " . TEMPLATE . '403.php');
}
$role = strip_tags(htmlspecialchars(AccountInfo::getRole()));
$userID = strip_tags(htmlspecialchars($_GET['id']));
CheckUID::GetuID($userID, $conn);

if ($role == 'admin' || $userID == $control) {
    $stmt = $conn->prepare("SELECT * FROM user WHERE userID = :userID");
    $stmt->bindParam(':userID', $userID);
    $stmt->execute();
    $user = $stmt->fetch();
    if (isset($_POST['delete'])) {
        $stmt = $conn->prepare('CALL editUDelete(:userID)');
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        if ($role != 'admin') {
            session_destroy();
        }
        header('Location: index.php');
    }
    if (isset($_POST['submit'])) {
        $userName = strip_tags($_POST['userName']);
        $email = strip_tags($_POST['email']);
        $stmt = $conn->prepare('CALL editUAll(:userName, :email, :userID)');
        $stmt->bindParam(':userName', $userName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        if ($role == 'admin') {
            $role = strip_tags($_POST['role']);
            $stmt = $conn->prepare('CALL editURole(:role, :userID)');
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':userID', $userID);
            $stmt->execute();
        }
        header('Location: index.php');
    }
} else {
    header("Location: " . TEMPLATE . '403.php');
}
?>

<main>
    <form class='form' method="POST" onsubmit='return confirm("Are you sure?")'>
        <div class='title'>Edit Profile</div>
        <div class="input-container ic1">
            <input type='text' id='userName' name='userName' class="input" value="<?php echo htmlspecialchars($user['userName']); ?>" required />
            <div class="cut"></div>
            <label for="userName" class="placeholder">User Name:</label>
        </div>
        <div class="input-container ic2">
            <input type='email' id='email' class="input" name='email' value="<?php echo htmlspecialchars($user['email']) ?>" required>
            <div class="cut cut-short"></div>
            <label for="email" class="placeholder">Email:</label>
        </div>
        <?php if ($role == 'admin') {
        ?>
            <style>
                .form {
                    height: 570px;
                }
            </style>
            <div class="input-container ic2">
                <select name='role' class="input" required>
                    <option value=""><?php echo htmlspecialchars($user['role']); ?></option>
                    <option value="admin">Admin</option>
                    <option value="organiser">Organiser</option>
                    <option value="participant">Participant</option>
                </select>
                <div class='cut cut-long'></div>
                <label for='role' class='placeholder'>Current Role:</label>
            </div>
        <?php
        } ?>
        <button class="submit" type="submit" name="submit">Edit Profile</button>
        <a href="index.php?page=editPassword&id=<?php echo strip_tags(htmlspecialchars($userID)) ?>"><button class='submitR' type="button">Reset Password</button></a>
        <button class='submitR' type='delete' name="delete">Delete Profile</button>
    </form>
</main>