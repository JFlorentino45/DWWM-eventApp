<?php
    include('./connection/connectionString.php');
    $id = $_SESSION['userID'];
    $role = $_SESSION['role'];
    
    if($role === 'admin') {
        $stmt = $conn->prepare('
    SELECT DISTINCT event.*
    FROM event');
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
    $stmt = $conn->prepare('
    SELECT DISTINCT event.*
    FROM event
    WHERE event.userID = :id');
    $stmt->execute(['id' => $id]);
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit events</title>
</head>
<body>
    <h1>My Events</h1>
    <div>
    <?php 
    foreach ($events as $event) {
        
    ?>
        <div class="event">
        <h1><?php echo $event['eventName']; ?></h1>
        <img class="eventImg" src="<?php echo $event['imageURL']; ?>" alt="<?php echo $event['eventName']; ?>">
        <p>Date: <?php echo $event['eventDate']; ?></p>
        <p>Description: <?php echo $event['description']; ?></p>
        <p><a href="index.php?page=editEvent">
            <button name="edit">Edit Event</button></a></p>
        </div>
    <?php
    }
    ?>
</div>
</body>
</html>