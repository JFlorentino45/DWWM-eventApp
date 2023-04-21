
<?php
    include('./connection/connectionString.php');
    $stmt = $conn->prepare('CALL homeGET()');
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<main>
    <div>
        <?php
    foreach ($events as $event) {
        ?>
        <div class="event">
            <img class="eventImg" src="<?php echo htmlspecialchars($event['imageURL']); ?>" alt="<?php echo htmlspecialchars($event['eventName']); ?>">
            <ul class="eventInfo">
                <li>
                    <h2><?php echo htmlspecialchars($event['eventName']); ?></h2>
                </li>
                <li>
                    <p class="date">Date: <?php echo htmlspecialchars($event['eventDate']); ?></p>
                </li>
                <li>
                    <a href="index.php?page=event&id=<?php echo htmlspecialchars($event['eventID']) ?>"><button>Details</button></a>
                </li>
            </ul>
        </div>
        <?php
    }
    ?>
    </div>
</main>