<?php
require_once('./connection/connectionString.php');
include_once('template/search.php');

$stmt = $conn->prepare(
    'CALL homeGET()');
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main>
    <div class='background-tophalf'></div>
    <h1 class='title'>Upcoming Events</h1>
    <input type="text" class="search-input" id="searchInput" onkeyup="filterEvents()" placeholder="Search by event name...">

    <div class='event-grid'>
        <?php
        foreach ($events as $event) {
        ?>
            <div class="event" data-name="<?php echo htmlspecialchars($event['eventName']); ?>">
                <a href="index.php?page=event&id=<?php echo htmlspecialchars($event['eventID']) ?>"><img class="event-img" src="<?php echo htmlspecialchars($event['imageURL']); ?>" alt="<?php echo htmlspecialchars($event['eventName']); ?>"></a>
                <div>
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