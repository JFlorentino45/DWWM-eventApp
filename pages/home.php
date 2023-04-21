
<?php
    include('./connection/connectionString.php');
    $stmt = $conn->prepare('CALL homeGET()');
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main>
    <div>
        <input type="text" class="search-input" id="searchInput" onkeyup="filterEvents()" placeholder="Search by event name...">
    </div>
    <div>
    <h1>Upcoming Events</h1>
    </div>
    
    <div class='event-grid'>
        <?php
        foreach ($events as $event) {
        ?>
        <div class="event" data-name="<?php echo htmlspecialchars($event['eventName']); ?>">
            <img class="event-img" src="<?php echo htmlspecialchars($event['imageURL']); ?>" alt="<?php echo htmlspecialchars($event['eventName']); ?>">
            <div class="event_details">
                <h2 class="event-name"><?php echo htmlspecialchars($event['eventName']); ?></h2>
                <p class="event-date">Date: <?php echo htmlspecialchars(date('Y-m-d H:i', strtotime($event['eventDate']))); ?></p>
                <a href="index.php?page=event&id=<?php echo htmlspecialchars($event['eventID']) ?>"><button class="buttonD">Details</button></a>
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
