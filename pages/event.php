
<main class="event1">
<?php
    // Include database connection file
    include('./connection/connectionString.php');
    // Get the event ID from the URL parameter
    $eventID = $_SESSION['eventID'];

    // Query the database for the event details
    $stmt = $conn->prepare("
    SELECT DISTINCT event.*, venue.*
    FROM event
    JOIN venue ON event.venueID = venue.venueID
    WHERE event.eventID = :id");
    $stmt->execute(['id' => $eventID]);
    $event = $stmt->fetch();


    // Check if the "addEvent" button has been clicked
    if(isset($_POST['addEvent'])) {
        // Get the current user ID from the session variable
        $userID = $_SESSION['userID'];

        // Check to see if the user is already signed up
        $stmt = $conn->prepare("SELECT COUNT(*) FROM participate WHERE userID = :userID AND eventID = :eventID");
        $stmt->execute(['userID' => $userID, 'eventID' => $id]);
        $count = $stmt->fetchColumn();

        //Check to see if there are still seats available
        $stmt = $conn->prepare("SELECT COUNT(*) FROM participate WHERE eventID = :eventID");
        $stmt->execute(['eventID' => $id]);
        $numParticipants = $stmt->fetchColumn();

        $totalSeats = $event['totalSeats'];

        if($count > 0) {
            echo "You have already signed up to this event!";
        } elseif($numParticipants = $totalSeats) {
           echo "Sorry, this event is full!"; 
        } else {
            // Insert the participation record into the database
            $stmt = $conn->prepare("INSERT INTO participate (userID, eventID) VALUES (:userID, :eventID)");
            $stmt->execute(['userID' => $userID, 'eventID' => $id]);
    
            // Display a success message
            echo "Event added to your events list!";
        }
    }
?>
<h1><?php echo $event['eventName']; ?></h1>
<img class="eventImg" src="<?php echo $event['imageURL']; ?>" alt="<?php echo $event['eventName']; ?>">
<p>Date: <?php echo $event['eventDate']; ?></p>
<p>Description: <?php echo $event['description']; ?></p>
<p>Venue: <?php echo $event['venueName']; ?><a href="index.php?page=venue">
        <form method="post">
        <input type="submit" name="venueID" value="More Info">
        </form>
    </a></p>
<p>Address: <?php echo $event['venueAddress']; ?></p>
<form method="post">
    <input type="submit" name="addEvent" value="Add Event">
</form>
<?php
if (isset($_POST['venueID'])) {
    $_SESSION['venueID'] = $_POST['venueID'];
    header('Location: index.php?page=venue');
}
?>
</main>