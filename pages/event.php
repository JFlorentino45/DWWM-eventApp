
<main>
<?php
    include('./connection/connectionString.php');
    require_once('./classes/AccountInfo.php');
    $eventID = $_GET['id'];
    $role = getRole();
    $userID = getUserID();
    
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
            $stmt = $conn->prepare("INSERT INTO participate (userID, eventID) VALUES (:userID, :eventID)");
            $stmt->execute(['userID' => $userID, 'eventID' => $eventID]);
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
if($role == 'admin')
{ ?>
    <p>total seats: <?php echo $event['totalSeats']; ?></p>
    <p>total people: <?php echo $numParticipants; ?></p>
<?php
} ?>
<p>Address: <?php echo $event['venueAddress']; ?></p>
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
    <p>To add event ->
    <a href="index.php?page=login"><button>Login</button></a>
     or <a href="index.php?page=newUser"><button>Create Account</button></a></p>
<?php
} ?>
</main>