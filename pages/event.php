<main class="event1">
<?php
    // Include database connection file
    include('../connection/connectionString.php');
    
    // Get the event ID from the URL parameter
    $id = $_GET['id'];

    // Query the database for the event details
    // $stmt = $conn->prepare("SELECT * FROM event WHERE eventID = :id");
    // $stmt->execute(['id' => $id]);
    // $event = $stmt->fetch();
    $stmt = $conn->prepare("
    SELECT DISTINCT event.*, venue.*
    FROM event
    JOIN venue ON event.venueID = venue.venueID
    WHERE event.eventID = :id");
    $stmt->execute(['id' => $id]);
    $event = $stmt->fetch();


    // Check if the "addEvent" button has been clicked
    if(isset($_POST['addEvent'])) {
        // Get the current user ID from the session variable
        session_start();
        $userID = $_SESSION['userID'];

        // Insert the participation record into the database
        $stmt = $conn->prepare("INSERT INTO participate (userID, eventID) VALUES (:userID, :eventID)");
        $stmt->execute(['userID' => $userID, 'eventID' => $id]);

        // Display a success message
        echo "Event added to your participation list!";
    }
?>
<h1><?php echo $event['eventName']; ?></h1>
<img class="eventImg" src="<?php echo $event['imageURL']; ?>" alt="<?php echo $event['eventName']; ?>">
<p>Date: <?php echo $event['eventDate']; ?></p>
<p>Description: <?php echo $event['description']; ?></p>
<p>Venue: <?php echo $event['venueName']; ?> <a href="/site/pages/venue.php?id=<?php echo $event['venueID']; ?>">
                <button name="clickme">More Info</button>
                </a></p>
<p>Address: <?php echo $event['venueAddress']; ?></p>
<form method="post">
    <input type="submit" name="addEvent" value="Add Event">
</form>
</main>