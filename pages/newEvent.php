
<?php
include('./connection/connectionString.php');
require_once('./classes/AccountInfo.php');
$role = getRole();
$userID = getUserID();
if($role == 'admin' || $role == 'organiser') {
    if(isset($_POST['submit'])) {
        $eventName = strip_tags($_POST['eventName']);
        $eventDate = strip_tags($_POST['eventDate']);
        $venueID = strip_tags($_POST['venueID']);
        $description = strip_tags($_POST['description']);
        $eventOrganiser = strip_tags($_POST['eventOrganiser']);
        $totalSeats = strip_tags($_POST['totalSeats']);
        $imageURL = strip_tags($_POST['imageURL']);
        $stmt = $conn->prepare("CALL newEventCreate(:userID, :eventName, :eventDate, :venueID, :description, :eventOrganiser, :totalSeats, :imageURL)");
        $stmt->bindParam(':userID', $userID);
        $stmt->bindParam(':eventName', $eventName);
        $stmt->bindParam(':eventDate', $eventDate);
        $stmt->bindParam(':venueID', $venueID);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':eventOrganiser', $eventOrganiser);
        $stmt->bindParam(':totalSeats', $totalSeats);
        $stmt->bindParam(':imageURL', $imageURL);
        $stmt->execute();
    
        header('Location: index.php');
        exit();
    }
    $venuesStmt = $conn->prepare("CALL newEventGetVenue()");
    $venuesStmt->execute();
    $venues = $venuesStmt->fetchAll(PDO::FETCH_ASSOC);
} else{
    header("Location: ". TEMPLATE . '403.php');
}
?>

<main>
    <h1>Create Event</h1>
    <form method="post">
        <label>Event Name:</label>
        <input type="text" name="eventName" required>
        <label>Event Date:</label>
        <input type="datetime-local" name="eventDate" required>
        <label>Venue:</label>
        <select name="venueID" required>
            <option value="">Select a venue</option>
            <?php foreach($venues as $venue) { ?>
                <option value="<?php echo htmlspecialchars($venue['venueID']); ?>"><?php echo htmlspecialchars($venue['venueName']) . " " . htmlspecialchars($venue['venuePostalCode']); ?></option>
                <?php } ?>
        </select>
        <label>Description:</label>
        <textarea name="description" rows="5" cols="33" required></textarea>
        <label>Event Organiser:</label>
        <input type="text" name="eventOrganiser" required>
        <label>Total Seats:</label>
        <input type="number" name="totalSeats" required>
        <label>Image Url:</label>
        <input type="text" name="imageURL" required>
        <input type="submit" name="submit" value="Create Event">
    </form>
    <a href="index.php?page=newVenue"><button name="new venue">New Venue</button></a>
</main>
