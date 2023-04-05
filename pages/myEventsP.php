<?php
include('./connection/connectionString.php');
require_once('./classes/AccountInfo.php');
$role = getRole();
$userID = getUserID();
var_dump($role);
if($role == 'participant'){
    $stmt = $conn->prepare(
        'SELECT DISTINCT event.*, participate.*, venue.*
        FROM event
        JOIN participate ON event.eventID = participate.eventID
        JOIN venue ON event.venueID = venue.venueID
        WHERE participate.userID = :id');
    $stmt->execute(['id' => $userID]);
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if(isset($_POST['removeEvent'])) {        
        $stmt = $conn->prepare(
            'DELETE 
            FROM participate 
            WHERE userID = :userID AND eventID = :eventID');
        $stmt->execute(['userID' => $userID, 'eventID' => $_POST['eventID']]);        
        echo "Event removed from My Events!";
        header('Location: #');
    }
} else{
    header("Location: ". TEMPLATE . '404.php');
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
            <h1><?php echo $event['eventName']; ?></h1>
            <img class="eventImg" src="<?php echo $event['imageURL']; ?>" alt="<?php echo $event['eventName']; ?>">
            <p>Date: <?php echo $event['eventDate']; ?></p>
            <p>Description: <?php echo $event['description']; ?></p>
            <p>Venue: <?php echo $event['venueName']; ?> <a href="index.php?page=venue">
                <button name="clickme">More Info</button></a></p>
            <p>Address: <?php echo $event['venueAddress']; ?></p>
            <p> <?php echo $event['eventID']; ?></p>
            <form method="post">
                <input type="hidden" name="eventID" value="<?php echo $event['eventID']; ?>">
                <input type="submit" name="removeEvent" value="Remove Event">
            </form>
            </div>
        <?php
        }
        ?>
    </div>
</main>

