<?php
require_once('./connection/connectionString.php');
require_once('./classes/AccountInfo.php');
$userID = getUserID();

if($userID){
    $stmt = $conn->prepare("SELECT userName, email FROM user WHERE userID = $userID");
    $stmt->execute();
    $info = $stmt->fetch();
} else{
    header("Location: ". TEMPLATE . '404.php');
}
?>

<main>
    <p>User Name: <?= $info['userName'] ?></p>
    <p>Email: <?= $info['email'] ?> </p>
    <a href="index.php?page=editUser&id=<?= $userID?>"><button>Edit Profile</button></a>
</main>
