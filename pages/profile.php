<?php
require_once('./connection/connectionString.php');
require_once('./classes/AccountInfo.php');

$userID = AccountInfo::getUserID();

if ($userID) {
    $stmt = $conn->prepare(
        "CALL profileGet(:userID)");
    $stmt->bindParam(':userID', $userID);
    $stmt->execute();
    $info = $stmt->fetch();
} else {
    header("Location: " . TEMPLATE . '403.php');
}
?>

<main>
    <div class='form'>
        <div class='title'>Welcome back, <?= htmlspecialchars($info['userName']) ?></div>
        <div class='subtitle'>Email: <?= htmlspecialchars($info['email']) ?> </div>
        <a href="index.php?page=editUser&id=<?= $userID ?>"><button class='submit'>Edit Profile</button></a>
    </div>
</main>