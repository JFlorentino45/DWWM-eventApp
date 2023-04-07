<?php
include('./connection/connectionString.php');
require_once('./classes/AccountInfo.php');
$userID = getUserID();
$role = getRole();

if($role == 'admin') {
    $stmt = $conn->prepare('CALL myEOAdmin()');
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif($role == 'organiser') {
    $stmt = $conn->prepare('CALL myEOOrg(:userID)');
    $stmt->bindParam(':userID', $userID);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else{
    header("Location: ". TEMPLATE . '403.php');
}
?>

<main>
    <h1>Events</h1>
    <div>
    <?php 
    foreach ($events as $event) {
    ?>
        <div class="event">
        <h1><?php echo htmlspecialchars($event['eventName']); ?></h1>
        <img class="eventImg" src="<?php echo htmlspecialchars($event['imageURL']); ?>" alt="<?php echo htmlspecialchars($event['eventName']); ?>">
        <p>Date: <?php echo htmlspecialchars($event['eventDate']); ?></p>
        <p>Description: <?php echo htmlspecialchars($event['description']); ?></p>
        <p><a href="index.php?page=editEvent&id=<?php echo htmlspecialchars($event['eventID']) ?>">
            <button name="edit">Edit Event</button>
        </a>
        <a href="index.php?page=removeEvent&id=<?php echo htmlspecialchars($event['eventID']) ?>">
            <button name="remove">Remove Event</button>
        </a></p>
        </div>
    <?php
    }
    ?>
    </div>
</main>