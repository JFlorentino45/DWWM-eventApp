<?php
include('./connection/connectionString.php');
require_once('./classes/AccountInfo.php');
require_once('./classes/CheckEID.php');
$eventID = $_GET['id'];
GeteID($eventID, $conn);
$role = getRole();
$userID = getUserID();

$stmt = $conn->prepare("SELECT DISTINCT event.*, venue.*
FROM event
JOIN venue ON event.venueID = venue.venueID
WHERE event.eventID = :eventID");
$stmt->execute(['eventID' => $eventID]);
$event = $stmt->fetch();

$stmt = $conn->prepare("SELECT COUNT(*) FROM participate WHERE eventID = :eventID");
$stmt->execute(['eventID' => $eventID]);
$numParticipants = $stmt->fetchColumn();

if(isset($_POST['addEvent'])) {

    $stmt = $conn->prepare("SELECT COUNT(*) FROM participate WHERE userID = :userID AND eventID = :eventID");
    $stmt->execute(['userID' => $userID, 'eventID' => $eventID]);
    $count = $stmt->fetchColumn();

    $totalSeats = $event['totalSeats'];

    if($count > 0) {
        echo "You have already signed up to this event!";
    } elseif($numParticipants == $totalSeats) {
        echo "Sorry, this event is full!"; 
    } else {
        $stmt = $conn->prepare('CALL eventAdd(:userID, :eventID)');
        $stmt->bindParam(':userID', $userID);
        $stmt->bindParam(':eventID', $eventID);
        $stmt->execute();
        echo "Event added to your events list!";
    }
}
?>

<main>
    <h1><?php echo htmlspecialchars($event['eventName']); ?></h1>
    <img class="eventImg" src="<?php echo htmlspecialchars($event['imageURL']); ?>" alt="<?php echo htmlspecialchars($event['eventName']); ?>">
    <p>Date: <?php echo htmlspecialchars($event['eventDate']); ?></p>
    <p>Description: <?php echo htmlspecialchars($event['description']); ?></p>
    <p>Venue: <?php echo htmlspecialchars($event['venueName']); ?><a href="index.php?page=venue&id=<?php echo htmlspecialchars($event['venueID']) ?>"><button>Venue info</button></a></p>
    <?php
    if($role == 'admin')
    { ?>
        <p>total seats: <?php echo htmlspecialchars($event['totalSeats']); ?></p>
        <p>total people: <?php echo htmlspecialchars($numParticipants); ?></p>
    <?php
    } ?>
    <p>Address: <?php echo htmlspecialchars($event['venueAddress']); ?></p>
    <?php
    if($role == 'participant')
    { ?>
        <form method="post">
            <input type="submit" name="addEvent" value="Sign Up">
        </form>
    <?php
    } ?>
    <?php
    if($role == 'guest')
    { ?>
        <p>To sign up for an event ->
        <a href="index.php?page=login&id=<?= htmlspecialchars($eventID)?>"><button>Login</button></a>
        or <a href="index.php?page=newUser&id=<?= htmlspecialchars($eventID)?>"><button>Create Account</button></a></p>
    <?php
    } ?>
</main>