<?php
require_once('./connection/connectionString.php');
require_once('./classes/AccountInfo.php');
require_once('./classes/CheckEID.php');
require_once('./classes/EventLogic.php');

$eventID = strip_tags(htmlspecialchars($_GET['id']));
CheckEID::GeteID($eventID, $conn);
$role = strip_tags(htmlspecialchars(AccountInfo::getRole()));
$userID = strip_tags(htmlspecialchars(AccountInfo::getUserID()));
$event = EventLogic::getEventDetails($eventID, $conn);
$numParticipants = EventLogic::getNumParticipants($eventID, $conn);
$attending = EventLogic::getAttendingStatus($eventID, $userID, $conn);
$count = EventLogic::getCountForUser($eventID, $userID, $conn);
$totalSeats = $event['totalSeats'];
$seatsRemaining = EventLogic::calculateRemainingSeats($eventID, $conn);

if (isset($_POST['addEvent'])) {
    if ($count > 0) {
        echo "<script>alert('You have already signed up for this event!');</script>";
    } else {
        EventLogic::addEvent($userID, $eventID, $conn);
        echo "<script>alert('Event added to your events list!'); window.location='index.php?page=myEventsP';</script>";
    }
}
?>

<main>
    <h1><?php echo htmlspecialchars($event['eventName']); ?></h1>
    <img class="event-img" src="<?php echo htmlspecialchars($event['imageURL']); ?>" alt="<?php echo htmlspecialchars($event['eventName']); ?>">
    <div class="event-details">
        <p class='event-date'>Date: <?php echo htmlspecialchars(date('Y-m-d H:i', strtotime($event['eventDate']))); ?></p>
        <p class='event-date'>Description: <?php echo htmlspecialchars($event['description']); ?></p>
        <p class='event-date'>Venue: <?php echo htmlspecialchars($event['venueName']); ?><a href="index.php?page=venue&id=<?php echo htmlspecialchars($event['venueID']) ?>"><button class="buttonD">Venue info</button></a></p>
        <?php
        if ($role == 'admin') { ?>
            <p class='event-date'>total seats: <?php echo htmlspecialchars($event['totalSeats']); ?></p>
            <p class='event-date'>total people: <?php echo htmlspecialchars($numParticipants); ?></p>
        <?php
        } ?>
        <p class='event-date'>Address: <?php echo htmlspecialchars($event['venueAddress']); ?></p>
        <?php
        if ($seatsRemaining < 11 && $seatsRemaining > 1) {
        ?> <h3>Only <?= $seatsRemaining ?> seats left!</h3> <?php
        } elseif ($seatsRemaining == 1) {
            ?> <h3>Only <?= $seatsRemaining ?> seat left!</h3> <?php
        }
        if ($numParticipants == $totalSeats) {
            ?> <h3>Sorry this event is full</h3> <?php
        } else {
            if ($role == 'participant' && $attending == null) { ?>
                <form method="post">
                    <button class="buttonD" type="submit" name="addEvent">Sign Up</button>
                </form>
            <?php
            } ?>
            <?php
            if ($role == 'guest') { ?>
                <p class='event-date'>To sign up for this event ->
                    <a href="index.php?page=login&id=<?= htmlspecialchars($eventID) ?>"><button class="buttonD">Login</button></a>
                    or <a href="index.php?page=newUser&id=<?= htmlspecialchars($eventID) ?>"><button class="buttonD">Create Account</button></a>
                </p>
        <?php
            }
        } ?>
    </div>
</main>