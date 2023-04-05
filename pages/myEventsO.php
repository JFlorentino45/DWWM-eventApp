<?php
include('./connection/connectionString.php');
require_once('./classes/AccountInfo.php');
$id = getUserID();
$role = getRole();

if($role == 'admin') {
    $stmt = $conn->prepare(
        'SELECT DISTINCT event.*
        FROM event');
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif($role == 'organiser') {
    $stmt = $conn->prepare(
        'SELECT DISTINCT event.*
        FROM event
        WHERE event.userID = :id');
    $stmt->execute(['id' => $id]);
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else{
    header("Location: ". TEMPLATE . '404.php');
}
?>

<main>
    <h1>Events</h1>
    <div>
    <?php 
    foreach ($events as $event) {
    ?>
        <div class="event">
        <h1><?php echo $event['eventName']; ?></h1>
        <img class="eventImg" src="<?php echo $event['imageURL']; ?>" alt="<?php echo $event['eventName']; ?>">
        <p>Date: <?php echo $event['eventDate']; ?></p>
        <p>Description: <?php echo $event['description']; ?></p>
        <p><a href="index.php?page=editEvent&id=<?php echo $event['eventID'] ?>">
            <button name="edit">Edit Event</button>
        </a>
        <a href="index.php?page=removeEvent&id=<?php echo $event['eventID'] ?>">
            <button name="remove">Remove Event</button>
        </a></p>
        </div>
    <?php
    }
    ?>
    </div>
</main>