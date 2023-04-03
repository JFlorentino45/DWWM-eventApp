
<main>
<?php
    // Include database connection file
    include('./connection/connectionString.php');
    // Get the event ID from the URL parameter
    $eventID = $_GET['id'];

    // Query the database for the event details
    $stmt = $conn->prepare("
    SELECT DISTINCT event.*, venue.*
    FROM event
    JOIN venue ON event.venueID = venue.venueID
    WHERE event.eventID = :eventID");
    $stmt->execute(['eventID' => $eventID]);
    $event = $stmt->fetch();

    $stmt = $conn->prepare("SELECT COUNT(*) FROM participate WHERE eventID = :eventID");
    $stmt->execute(['eventID' => $eventID]);
    $numParticipants = $stmt->fetchColumn();

    // Check if the "addEvent" button has been clicked
    if(isset($_POST['addEvent'])) {
        // Get the current user ID from the session variable
        $userID = $_SESSION['userID'];

        // Check to see if the user is already signed up
        $stmt = $conn->prepare("SELECT COUNT(*) FROM participate WHERE userID = :userID AND eventID = :eventID");
        $stmt->execute(['userID' => $userID, 'eventID' => $eventID]);
        $count = $stmt->fetchColumn();

        //Check to see if there are still seats available

        $totalSeats = $event['totalSeats'];

        if($count > 0) {
            echo "You have already signed up to this event!";
        } elseif($numParticipants == $totalSeats) {
           echo "Sorry, this event is full!"; 
        } else {
            // Insert the participation record into the database
            $stmt = $conn->prepare("INSERT INTO participate (userID, eventID) VALUES (:userID, :eventID)");
            $stmt->execute(['userID' => $userID, 'eventID' => $eventID]);
    
            // Display a success message
            echo "Event added to your events list!";
        }
    }
?>
<h1><?php echo $event['eventName']; ?></h1>
<img class="eventImg" src="<?php echo $event['imageURL']; ?>" alt="<?php echo $event['eventName']; ?>">
<p>Date: <?php echo $event['eventDate']; ?></p>
<p>Description: <?php echo $event['description']; ?></p>
<p>Venue: <?php echo $event['venueName']; ?><a href="index.php?page=venue&id=<?php echo $event['venueID'] ?>"><button>Venue info</button></a></p>
<?php
if($_SESSION['role'] == 'admin')
{ ?>
<p>total seats: <?php echo $event['totalSeats']; ?></p>
<p>total people: <?php echo $numParticipants; ?></p>
<?php
} ?>
<p>Address: <?php echo $event['venueAddress']; ?></p>
<form method="post">
    <input type="submit" name="addEvent" value="Add Event">
</form>
</main>