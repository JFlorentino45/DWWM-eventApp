
<?php
include('./connection/connectionString.php');
require_once('./classes/AccountInfo.php');
$role = getRole();
$userID = getUserID();
if($role == 'admin' || $role == 'organiser') {
    // Check if the form has been submitted
    if(isset($_POST['submit'])) {
        // Get the event details from the form
        $eventName = $_POST['eventName'];
        $eventDate = $_POST['eventDate'];
        $venueID = $_POST['venueID'];
        $description = $_POST['description'];
        $eventOrganiser = $_POST['eventOrganiser'];
        $totalSeats = $_POST['totalSeats'];
        $imageURL = $_POST['imageURL'];
        // Insert the event details into the events table
        $stmt = $conn->prepare("INSERT INTO event (userID, eventName, eventDate, venueID, description, eventOrganiser, totalSeats, imageURL) VALUES (:userID, :eventName, :eventDate, :venueID, :description, :eventOrganiser, :totalSeats, :imageURL)");
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
    $venuesStmt = $conn->prepare("SELECT venueID, venueName,venuePostalCode FROM venue");
    $venuesStmt->execute();
    $venues = $venuesStmt->fetchAll(PDO::FETCH_ASSOC);
} else{
    header("Location: ". TEMPLATE . '404.php');
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
                <option value="<?php echo $venue['venueID']; ?>"><?php echo $venue['venueName'] . " " . $venue['venuePostalCode']; ?></option>
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
