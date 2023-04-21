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

    <input type="text" class="search-input" id="searchInput" onkeyup="filterEvents()" placeholder="Search by event name...">

    <div class='event-grid'>
        <?php 
        foreach ($events as $event) {
        ?>
            <div class="event" data-name="<?php echo htmlspecialchars($event['eventName']); ?>">
                <img class="event-img" src="<?php echo htmlspecialchars($event['imageURL']); ?>" alt="<?php echo htmlspecialchars($event['eventName']); ?>">
                <div class="event_details">
                    <h2 class="event-name"><?php echo htmlspecialchars($event['eventName']); ?></h2>
                    <p class="event-date">Date: <?php echo htmlspecialchars(date('Y-m-d H:i', strtotime($event['eventDate']))); ?></p>
                    <p><a href="index.php?page=editEvent&id=<?php echo htmlspecialchars($event['eventID']) ?>">
                        <button name="edit">Edit Event</button>
                    </a>
                    <a href="index.php?page=removeEvent&id=<?php echo htmlspecialchars($event['eventID']) ?>">
                        <button name="remove">Remove Event</button>
                    </a></p>
                </div>
            </div>
    <?php
    }
    ?>
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