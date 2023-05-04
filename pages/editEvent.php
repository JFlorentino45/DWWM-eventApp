<?php
require_once('./connection/connectionString.php');
require_once('./classes/CheckEID.php');
require_once('./classes/AccountInfo.php');

$role = strip_tags(htmlspecialchars(AccountInfo::getRole()));
$userID = strip_tags(htmlspecialchars(AccountInfo::getUserID()));
$eventID = strip_tags(htmlspecialchars($_GET['id']));
CheckEID::GeteID($eventID, $conn);

$stmt = $conn->prepare('SELECT * FROM event WHERE eventID = :eventid');
$stmt->execute(['eventid' => $eventID]);
$event = $stmt->fetch();
if ($role == 'admin' || $event['userID'] == $userID) {

    if (isset($_POST['submit'])) {
        $eventName = strip_tags($_POST['eventName']);
        $eventDate = strip_tags($_POST['eventDate']);
        $venueID = strip_tags($_POST['newVenueID']);
        $description = strip_tags($_POST['description']);
        $eventOrganiser = strip_tags($_POST['eventOrganiser']);
        $totalSeats = strip_tags($_POST['totalSeats']);
        $imageURL = strip_tags($_POST['imageURL']);

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
    $venuesStmt = $conn->prepare('SELECT venueID, venueName,venuePostalCode FROM venue');
    $venuesStmt->execute();
    $venueID = $event['venueID'];
    $venues = $venuesStmt->fetchAll(PDO::FETCH_ASSOC);
    $venueStmt = $conn->prepare('SELECT venueName FROM venue where venueID = :venueID');
    $venueStmt->bindParam(':venueID', $venueID);
    $venueStmt->execute();
    $venue = $venueStmt->fetch();
} else {
    header("Location: " . TEMPLATE . '403.php');
}
?>

<main>
    <form method="POST" class="form "onsubmit='return confirm("Are you sure you want to edit this event?")'>
        <div class='title'>Edit Event</div>
        <div class="input-container ic1">
            <input id="eventName" name="eventName" class="input" type="text" value="<?php echo htmlspecialchars($event['eventName']); ?>" required />
            <div class="cut"></div>
            <label for="eventName" class="placeholder">Name</label>
        </div>
        <div class="input-container ic2">
            <input id="eventDate" name="eventDate" class="input" type="datetime-local" value='<?php echo htmlspecialchars($event['eventDate']) ?>' required />
            <div class="cut"></div>
            <label for="eventDate" class="placeholder">Date</label>
        </div>
        <div class="input-container ic2">
            <select id="newVenueID" name="newVenueID" class="input" placeholder=" " required>
                <option value=""><?php echo htmlspecialchars($venue['venueName']); ?></option>
                <?php foreach ($venues as $venue) { ?>
                    <option value="<?php echo htmlspecialchars($venue['venueID']); ?>"><?php echo htmlspecialchars($venue['venueName']) . " " . htmlspecialchars($venue['venuePostalCode']); ?></option>
                <?php } ?>
            </select>
            <div class="cut"></div>
            <label for="venueID" class="placeholder">Venue</label>
        </div>
        <div class="input-container ic2">
            <input id="description" name="description" class="input disc" type='text' value='<?php echo htmlspecialchars($event['description']); ?>' required />
            <div class="cut"></div>
            <label for="description" class="placeholder">Description</label>
        </div>
        <div class="input-container ic2">
            <input id="eventOrganiser" name="eventOrganiser" class="input" type="text" value='<?php echo htmlspecialchars($event['eventOrganiser']); ?>' required />
            <div class="cut"></div>
            <label for="eventOrganiser" class="placeholder">Event Organiser</label>
        </div>
        <div class="input-container ic2">
            <input id="totalSeats" name="totalSeats" class="input" type="number" value='<?php echo htmlspecialchars($event['totalSeats']); ?>' required />
            <div class="cut"></div>
            <label for="totalSeats" class="placeholder">Total Seats</label>
        </div>
        <div class="input-container ic2">
            <input id="imageURL" name="imageURL" class="input" type="text" value='<?php echo htmlspecialchars($event['imageURL']); ?>' required />
            <div class="cut"></div>
            <label for="imageURL" class="placeholder">Image Url</label>
        </div>
        <input type='submit' class='submit' name='submit' value='Edit Event'>
    </form>
</main>