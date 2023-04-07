<?php
require_once('./connection/connectionString.php');
require_once('./classes/AccountInfo.php');
$userID = getUserID();

if($userID){
        $stmt = $conn->prepare("CALL profileGet(:userID)");
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        $info = $stmt->fetch();
} else{
    header("Location: ". TEMPLATE . '403.php');
}
?>

<main>
    <p>User Name: <?= htmlspecialchars($info['userName']) ?></p>
    <p>Email: <?= htmlspecialchars($info['email']) ?> </p>
    <a href="index.php?page=editUser&id=<?= $userID?>"><button>Edit Profile</button></a>
</main>
