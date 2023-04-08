<?php 
include('./connection/connectionString.php');
require_once('./classes/AccountInfo.php');
require_once('./classes/CheckUID.php');

$control = getUserID();

if($control == ''){
    header("Location: ". TEMPLATE . '403.php');
}
$role = getRole();
$userID = $_GET['id'];
GetuID($userID, $conn);

if($role == 'admin' || $userID == getUserID()){
    $stmt = $conn->prepare("SELECT * FROM user WHERE userID = :userid");
    $stmt->execute(['userid' => $userID]);
    $user = $stmt->fetch();
    if(isset($_POST['delete'])) {
        $stmt = $conn->prepare('CALL editUDelete(:userID)');
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        header('Location: index.php');
    }
    if(isset($_POST['submit'])) {
        $userName = strip_tags($_POST['userName']);
        $email = strip_tags($_POST['email']);
        $stmt = $conn->prepare('CALL editUAll(:userName, :email, :userID)');
        $stmt->bindParam(':userName', $userName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        if($role == 'admin'){
        $role = strip_tags($_POST['role']);
        $stmt = $conn->prepare('CALL editURole(:role, :userID)');
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        }
        header('Location: index.php');
    }

} else{
    header("Location: ". TEMPLATE . '403.php');
}
?>

<main>
    <h1>Edit Profile</h1>
    <form method="POST" onsubmit='return confirm("Are you sure?")'>
        <label>User Name:</label>
        <input type='text' id='userName' name='userName' value="<?php echo htmlspecialchars($user['userName']); ?>">
        <label>Email:</label>
        <input type='email' id='email' name='email' value="<?php echo htmlspecialchars($user['email'])?>" required>
        <?php if($role == 'admin'){
        ?>
            <label>Current Role:</label>
            <select name='role' required>
                <option value=""><?php echo htmlspecialchars($user['role']); ?></option>
                <option value="admin">Admin</option>
                <option value="organiser">Organiser</option>
                <option value="participant">Participant</option>
            </select>
            <input type="submit" name="delete" value="Delete Profile">
        <?php
        } ?>
        <input type="submit" name="submit" value="Edit Profile">
    </form>
    <a href="index.php?page=editPassword&id=<?php echo htmlspecialchars($userID)?>">Reset Password</a>
</main>