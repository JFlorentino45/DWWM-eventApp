<?php
require_once('./connection/connectionString.php');
require_once('./classes/CheckEID.php');
require_once('./classes/AccountInfo.php');
$role = getRole();
$userID = getUserID();
$eventID = $_GET['id'];
GeteID($eventID, $conn);

$stmt = $conn->prepare("SELECT * FROM event WHERE eventID = :eventid");
$stmt->execute(['eventid' => $eventID]);
$event = $stmt->fetch();
if($role == 'admin' || $event['userID'] == $userID){
    
    if(isset($_POST['submit'])) {
        // Get the event details from the form
        $eventName = strip_tags($_POST['eventName']);
        $eventDate = strip_tags($_POST['eventDate']);
        $venueID = strip_tags($_POST['newVenueID']);
        $description = strip_tags($_POST['description']);
        $eventOrganiser = strip_tags($_POST['eventOrganiser']);
        $totalSeats = strip_tags($_POST['totalSeats']);
        $imageURL = strip_tags($_POST['imageURL']);
    
        // Insert the event details into the events table
        $stmt = $conn->prepare('CALL editEUpdate(:eventName, :eventDate, :venueID, :description, :eventOrganiser, :totalSeats, :imageURL, :eventID)');
        $stmt->bindParam(':eventName', $eventName);
        $stmt->bindParam(':eventDate', $eventDate);
        $stmt->bindParam(':venueID', $venueID);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':eventOrganiser', $eventOrganiser);
        $stmt->bindParam(':totalSeats', $totalSeats);
        $stmt->bindParam(':imageURL', $imageURL);
        $stmt->bindParam(':eventID', $eventID);
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
    header("Location: ". TEMPLATE . '403.php');
}
?>

<main>
    <h1>Edit Event</h1>
    <form method="POST" onsubmit='return confirm("Are you sure you want to edit this event?")'>
        <label>Event Name:</label>
        <input type="text" name="eventName" value="<?php echo htmlspecialchars($event['eventName']); ?>">
        <label>Event Date:</label>
        <input type="datetime-local" name="eventDate" value="<?php echo htmlspecialchars($event['eventDate']); ?>">
        <label>Venue:</label>
        <select name="newVenueID" required>
            <option value=""><?php echo htmlspecialchars($venue['venueName']); ?></option>
            <?php foreach($venues as $venue) { ?>
                <option value="<?php echo htmlspecialchars($venue['venueID']); ?>"><?php echo htmlspecialchars($venue['venueName']) . " " . htmlspecialchars($venue['venuePostalCode']); ?></option>
                <?php } ?>
        </select>
        <label>Description:</label>
        <input name="description" value="<?php echo htmlspecialchars($event['description']); ?>" required></input>
        <label>Event Organiser:</label>
        <input type="text" name="eventOrganiser" value="<?php echo htmlspecialchars($event['eventOrganiser']); ?>" required>
        <label>Total Seats:</label>
        <input type="number" name="totalSeats" value="<?php echo htmlspecialchars($event['totalSeats']); ?>" required>
        <label>Image Url:</label>
        <input type="text" name="imageURL" value="<?php echo htmlspecialchars($event['imageURL']); ?>" required>
        <input type="submit" name="submit" value="Edit Event">
    </form>
</main>