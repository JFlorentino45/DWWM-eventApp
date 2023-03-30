<?php
if($_SESSION['role'] === 'admin') {
    include('../connection/connectionString.php');
    $stmt = $conn->prepare("SELECT * FROM user");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    </div>
    <?php
}
?>
</div>
<?php
}
else {
    header("Location: ./template/404.php");
}