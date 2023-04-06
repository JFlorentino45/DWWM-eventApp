<?php 
include('./connection/connectionString.php');
require_once('./classes/AccountInfo.php');
$control = getUserID();

if($control == ''){
    header("Location: ". TEMPLATE . '404.php');
}
$role = getRole();
$userID = $_GET['id'];
if($role == 'admin' || $userID == getUserID()){
    $stmt = $conn->prepare("SELECT * FROM user WHERE userID = :userid");
    $stmt->execute(['userid' => $userID]);
    $user = $stmt->fetch();
    if(isset($_POST['submit'])) {
        $userName = $_POST['userName'];
        $email = $_POST['email'];
        $stmt = $conn->prepare(
            'UPDATE user 
            SET userName = :userName, email = :email
            WHERE userID = :userID');
        $stmt->bindParam(':userName', $userName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        if($role == 'admin'){
        $role = $_POST['role'];
        $stmt = $conn->prepare(
            'UPDATE user 
            SET role = :role 
            WHERE userID = :userID');
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        }
        header('Location: index.php');
    }

} else{
    header("Location: ". TEMPLATE . '404.php');
}
?>

<main>
    <h1>Edit Profile</h1>
    <form method="POST">
        <label>User Name:</label>
        <input type='text' id='userName' name='userName' value="<?php echo $user['userName']; ?>">
        <label>Email:</label>
        <input type='email' id='email' name='email' value="<?php echo $user['email']?>" required>
        <?php if($role == 'admin'){
        ?>
            <label>Current Role:</label>
            <select name='role' required>
                <option value=""><?php echo $user['role']; ?></option>
                <option value="admin">Admin</option>
                <option value="organiser">Organiser</option>
                <option value="participant">Participant</option>
            </select>
        <?php
        } ?>
        <input type="submit" name="submit" value="Edit Profile">
    </form>
    <a href="index.php?page=editPassword&id=<?php echo $userID?>">Reset Password</a>
</main>