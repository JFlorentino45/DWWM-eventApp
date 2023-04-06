<?php
require_once('./connection/connectionString.php');
require_once('./classes/AccountInfo.php');
$role = getRole();
$userID = getUserID();
$eventID = $_GET['id'];

if($role == 'admin' || $role == 'organiser'){
    if($role == 'admin'){
        $stmt = $conn->prepare("SELECT * FROM event WHERE eventID = :eventid");
        $stmt->execute(['eventid' => $eventID]);
    } else{
    $stmt = $conn->prepare("SELECT * FROM event WHERE eventID = :eventid AND userID = :userid");
    $stmt->execute(['eventid' => $eventID, 'userid' => $userID]);
    }
    $event = $stmt->fetch();
    if(isset($_POST['submit'])) {
        // Get the event details from the form
        $eventName = $_POST['eventName'];
        $eventDate = $_POST['eventDate'];
        $venueID = $_POST['newVenueID'];
        $description = $_POST['description'];
        $eventOrganiser = $_POST['eventOrganiser'];
        $totalSeats = $_POST['totalSeats'];
        $imageURL = $_POST['imageURL'];
    
        // Insert the event details into the events table
        $stmt = $conn->prepare("UPDATE event SET eventName = :eventName, eventDate = :eventDate, venueID = :venueID, description = :description, eventOrganiser = :eventOrganiser, totalSeats = :totalSeats, imageURL = :imageURL WHERE eventID = :eventID");
        $stmt->bindParam(':eventID', $eventID);
        $stmt->bindParam(':eventName', $eventName);
        $stmt->bindParam(':eventDate', $eventDate);
        $stmt->bindParam(':venueID', $venueID);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':eventOrganiser', $eventOrganiser);
        $stmt->bindParam(':totalSeats', $totalSeats);
        $stmt->bindParam(':imageURL', $imageURL);
        $stmt->execute();
    
        header('Location: index.php?page=myEventsO');
        exit();
    }
    $venuesStmt = $conn->prepare("SELECT venueID, venueName,venuePostalCode FROM venue");
    $venuesStmt->execute();
    $venueID = $event['venueID'];
    $venues = $venuesStmt->fetchAll(PDO::FETCH_ASSOC);
    $venueStmt = $conn->prepare("SELECT venueName FROM venue where venueID = $venueID");
    $venueStmt->execute();
    $venue = $venueStmt->fetch();

} else{
    header("Location: ". TEMPLATE . '404.php');
}
?>

<main>
    <h1>Edit Event</h1>
    <form method="POST">
        <label>Event Name:</label>
        <input type="text" name="eventName" value="<?php echo $event['eventName']; ?>">
        <label>Event Date:</label>
        <input type="datetime-local" name="eventDate" value="<?php echo $event['eventDate']; ?>">
        <!-- <p>Previous Venue: <?php echo $venue['venueName']; ?></p> -->
        <label>Venue:</label>
        <select name="newVenueID" required>
            <option value=""><?php echo $venue['venueName']; ?></option>
            <?php foreach($venues as $venue) { ?>
                <option value="<?php echo $venue['venueID']; ?>"><?php echo $venue['venueName'] . " " . $venue['venuePostalCode']; ?></option>
                <?php } ?>
        </select>
        <label>Description:</label>
        <input name="description" value="<?php echo $event['description']; ?>" required></input>
        <label>Event Organiser:</label>
        <input type="text" name="eventOrganiser" value="<?php echo $event['eventOrganiser']; ?>" required>
        <label>Total Seats:</label>
        <input type="number" name="totalSeats" value="<?php echo $event['totalSeats']; ?>" required>
        <label>Image Url:</label>
        <input type="text" name="imageURL" value="<?php echo $event['imageURL']; ?>" required>
        <input type="submit" name="submit" value="Edit Event">
    </form>
</main>