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
        ?> <h1>You are not signed up to any events</h1>
        <?php
        } else {
        ?>
        <div><input type="text" class="search-input" id="searchInput" onkeyup="filterEvents()" placeholder="Search by event name..."></div>
        <div class="event-grid">
        <?php
        foreach ($events as $event) {
            
        ?>
            <div class="event" data-name="<?php echo htmlspecialchars($event['eventName']); ?>">
            <h1><?php echo htmlspecialchars($event['eventName']); ?></h1>
            <a href="index.php?page=event&id=<?php echo htmlspecialchars($event['eventID']) ?>"><img class="event-img" src="<?php echo htmlspecialchars($event['imageURL']); ?>" alt="<?php echo htmlspecialchars($event['eventName']); ?>"></a>
            <p class="event-date">Date: <?php echo htmlspecialchars(date('Y-m-d H:i', strtotime($event['eventDate']))); ?></p>
            <p class='address'>Address: <?php echo htmlspecialchars($event['venueAddress']); ?></p>
            <div>
                <form method="post" onsubmit='return confirm("Are you sure you want unsubscribe from this event?")'>
                    <a href="index.php?page=event&id=<?php echo htmlspecialchars($event['eventID']) ?>"><button class="buttonD" type="button">Details</button></a>
                <input class='buttonR' type="hidden" name="eventID" value="<?php echo htmlspecialchars($event['eventID']); ?>">
                <input class='buttonR' type="submit" name="removeEvent" value="Remove Event">
            </form>
            </div>
            </div>
            <?php
        }
        }
        ?>
        </div>
    </div>
</main>

<script>
function filterEvents() {
    // Get input value
    var inputValue = document.getElementById("searchInput").value.toUpperCase();

    // Get all events
    var events = document.querySelectorAll(".event");

    // Loop through all events, and hide those that don't match the search query
    for (var i = 0; i < events.length; i++) {
        var eventName = events[i].getAttribute("data-name");
        if (eventName.toUpperCase().indexOf(inputValue) > -1) {
            events[i].style.display = "";
        } else {
            events[i].style.display = "none";
        }
    }
}
</script>