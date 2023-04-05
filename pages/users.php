<?php
require_once('./classes/AccountInfo.php');
$role = getRole();
if($role == 'admin') {
    include('./connection/connectionString.php');
    $stmt = $conn->prepare("SELECT * FROM user");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
else {
    header("Location: ". TEMPLATE . '404.php');
}
?>

<div>
    <?php
foreach ($users as $user) {
    ?>
    <div>
        <h2>user name: <?php echo $user['userName']; ?></h2>
        <h2>userID: <?php echo $user['userID']; ?></h2>
        <h2>email: <?php echo $user['email']; ?></h2>
        <h2>role: <?php echo $user['role']; ?></h2>
        <a href="index.php?page=editUser&id=<?php echo $user['userID']?>"><button>Edit User</button></a>
    </div>
    <?php
}
?>
</div>