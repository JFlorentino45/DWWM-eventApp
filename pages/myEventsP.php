<?php
include('./connection/connectionString.php');
require_once('./classes/AccountInfo.php');

$role = getRole();
$userID = getUserID();
if($role == 'participant'){
    $stmt = $conn->prepare('CALL myEPCheck(:userID)');
    $stmt->bindParam(':userID', $userID);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(isset($_POST['removeEvent'])) {        
        $eventID = $_POST['eventID'];
        $stmt = $conn->prepare('CALL myEPDelete(:userID, :eventID)');
        $stmt->bindParam(':userID', $userID);
        $stmt->bindParam(':eventID', $eventID);
        $stmt->execute();
        header('Location: #');
    }
} else{
    header("Location: ". TEMPLATE . '403.php');
}
?>
<main>
    <div>
        <?php 
        if(count($events) == 0){
        ?> <h2>You are not signed up to any events</h2>
        <?php
        }
        foreach ($events as $event) {
            
        ?>
            <div class="event">
            <h1><?php echo htmlspecialchars($event['eventName']); ?></h1>
            <img class="eventImg" src="<?php echo htmlspecialchars($event['imageURL']); ?>" alt="<?php echo htmlspecialchars($event['eventName']); ?>">
            <p>Date: <?php echo htmlspecialchars($event['eventDate']); ?></p>
            <p>Description: <?php echo htmlspecialchars($event['description']); ?></p>
            <p>Venue: <?php echo htmlspecialchars($event['venueName']); ?> <a href="index.php?page=venue&id=<?php echo htmlspecialchars($event['venueID']) ?>">
                <button name="clickme">More Info</button></a></p>
            <p>Address: <?php echo htmlspecialchars($event['venueAddress']); ?></p>
            <form method="post" onsubmit='return confirm("Are you sure you want unsubscribe from this event?")'>
                <input type="hidden" name="eventID" value="<?php echo htmlspecialchars($event['eventID']); ?>">
                <input type="submit" name="removeEvent" value="Remove Event">
            </form>
            </div>
        <?php
        }
        ?>
    </div>
</main>

