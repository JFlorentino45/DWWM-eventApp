<?php
require_once('./connection/connectionString.php');
require_once('./classes/AccountInfo.php');
$role = getRole();
$userID = getUserID();
$eventID = $_GET['id'];

$stmt = $conn->prepare("SELECT eventName FROM event WHERE eventID = $eventID");
$stmt->execute();
$event = $stmt->fetch();
$stmt = $conn->prepare("SELECT COUNT(*) FROM event WHERE userID = $userID AND eventID = $eventID");
$stmt->execute();
$count = $stmt->fetchColumn();

if($count > 0 || $role == 'admin'){
    if(isset($_POST['remove'])) {
    $stmt = $conn->prepare("DELETE FROM event WHERE eventID = $eventID");
    $stmt->execute();
    header('Location: index.php?page=myEventsO');
    }
} else{
    header("Location: ". TEMPLATE . '404.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Are you sure you want to delete '<?php echo $event['eventName'] ?>'</h2>
    <p><form method="post">
        <input type="submit" name="remove" value="Yes">
    </form>
    <a href="index.php?page=myEventsO"><button>No</button></a></p>
</body>
</html>