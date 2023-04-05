<?php 
include('./connection/connectionString.php');
require_once('./classes/AccountInfo.php');
$role = getRole();
$userID = $_GET['id'];

if($role == 'admin'){
    $stmt = $conn->prepare("SELECT * FROM user WHERE userID = :userid");
    $stmt->execute(['userid' => $userID]);
    $user = $stmt->fetch();

} else{
    header("Location: ". TEMPLATE . '404.php');
}
?>

<main>
    
</main>