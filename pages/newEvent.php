
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
    <form class='form' method="post">
        <div class='title'>Create Event</div>
        <div class="input-container ic1">
            <input id="eventName" name="eventName" class="input" type="text" placeholder=" " required/>
            <div class="cut"></div>
            <label for="eventName" class="placeholder">Event Name</label>
        </div>
        <div class="input-container ic2">
            <input id="eventDate" name="eventDate" class="input" type="datetime-local" placeholder=" " required/>
            <div class="cut"></div>
            <label for="eventDate" class="placeholder">Event Date</label>
        </div>
        <div class="input-container ic2">
            <select id="venueID" name="venueID" class="input" placeholder=" " required>
                <option value="">Select a venue</option>
            <?php foreach($venues as $venue) { ?>
                <option value="<?php echo htmlspecialchars($venue['venueID']); ?>"><?php echo htmlspecialchars($venue['venueName']) . " " . htmlspecialchars($venue['venuePostalCode']); ?></option>
                <?php } ?>
            </select>
            <div class="cut"></div>
            <label for="venueID" class="placeholder">Venue</label>
        </div>
        <div class="input-container ic2">
            <input id="description" name="description" class="input disc" type='text' placeholder=" " required/>
            <div class="cut"></div>
            <label for="description" class="placeholder">Description</label>
        </div>
        <div class="input-container ic2">
            <input id="eventOrganiser" name="eventOrganiser" class="input" type="text" placeholder=" " required/>
            <div class="cut"></div>
            <label for="eventOrganiser" class="placeholder">Event Organiser</label>
        </div>
        <div class="input-container ic2">
            <input id="totalSeats" name="totalSeats" class="input" type="number" placeholder=" " required/>
            <div class="cut"></div>
            <label for="totalSeats" class="placeholder">Total Seats</label>
        </div>
        <div class="input-container ic2">
            <input id="imageURL" name="imageURL" class="input" type="text" placeholder=" " required/>
            <div class="cut"></div>
            <label for="imageURL" class="placeholder">Image Url</label>
        </div>
        <input type="submit" class='submit' name="submit" value="Create Event">
    </form>
    <a href="index.php?page=newVenue"><button name="new venue">New Venue</button></a>
</main>
