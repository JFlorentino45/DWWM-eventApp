<?php
    include('./template/header.php');
    include('../connection/connectionString.php');

    $id = $_GET['id'];

    $stmt = $conn->prepare('
    SELECT DISTINCT event.*, participate.*, venue.*
    FROM event
    JOIN participate ON event.eventID = participate.eventID
    JOIN venue ON event.venueID = venue.venueID
    WHERE participate.userID = :id');
    $stmt->execute(['id' => $id]);
    $event = $stmt->fetch();
?>
<h1><?php echo $event['eventName']; ?></h1>
<img class="eventImg" src="<?php echo $event['imageURL']; ?>" alt="<?php echo $event['eventName']; ?>">
<p>Date: <?php echo $event['eventDate']; ?></p>
<p>Description: <?php echo $event['description']; ?></p>
<p>Venue: <?php echo $event['venueName']; ?> <a href="/site/pages/venue.php?id=<?php echo $event['venueID']; ?>">
                    <button name="clickme">More Info</button>
                    </a></p>
<p>Address: <?php echo $event['venueAddress']; ?></p>