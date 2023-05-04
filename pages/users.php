<?php
require_once('./classes/AccountInfo.php');
require_once('./connection/connectionString.php');

$role = strip_tags(htmlspecialchars(AccountInfo::getRole()));

if ($role == 'admin') {
    $stmt = $conn->prepare(
        "CALL usersGetAll()"
    );
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    header("Location: " . TEMPLATE . '403.php');
}
?>

<main>
    <div>
        <div class='title'><h2>Users</h2></div>
        <div class='users-grid'>
        <?php
        foreach ($users as $user) {
        ?>
            <div class='user form'>
                <h2>user name: <?php echo htmlspecialchars($user['userName']); ?></h2>
                <h2>userID: <?php echo htmlspecialchars($user['userID']); ?></h2>
                <h2>email: <?php echo htmlspecialchars($user['email']); ?></h2>
                <h2>role: <?php echo htmlspecialchars($user['role']); ?></h2>
                <a href="index.php?page=editUser&id=<?php echo htmlspecialchars($user['userID']) ?>"><button class="submit">Edit User</button></a>
            </div>
        <?php
        }
        ?>
        </div>
    </div>
</main>