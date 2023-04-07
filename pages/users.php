<?php
require_once('./classes/AccountInfo.php');
require_once('./connection/connectionString.php');
$role = getRole();
if($role == 'admin') {
    try {
        $stmt = $conn->prepare("CALL usersGetAll()");
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e){
        echo "Error executing the stored procedure: " . $e->getMessage();
    }
}
else {
    header("Location: ". TEMPLATE . '403.php');
}
?>

<main>
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
</main>