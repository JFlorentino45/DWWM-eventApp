
<?php
    include('./connection/connectionString.php');
    $stmt = $conn->prepare("SELECT * FROM event");
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // include('event.php')
?>
<div>
    <?php
foreach ($events as $event) {
    // $eventID = $event['eventID'];
    ?>
    <div class="event">
        <img class="eventImg" src="<?php echo $event['imageURL']; ?>" alt="<?php echo $event['eventName']; ?>">
        <ul class="eventInfo">
            <li>
                <h2><?php echo $event['eventName']; ?></h2>
            </li>
            <li>
                <p class="date">Date: <?php echo $event['eventDate']; ?></p>
            </li>
            <li>
                <a href="/site/pages/event.php?id=<?php echo $event['eventID']; ?>">
                <button name="clickme">More Info</button>
                </a>
            </li>
        </ul>
    </div>
    <?php
}
?>
</div>