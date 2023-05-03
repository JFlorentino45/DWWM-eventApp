<?php
require_once('./connection/connectionString.php');
require_once('./classes/AccountInfo.php');
require_once('./classes/CheckEID.php');

$role = AccountInfo::getRole();
$userID = AccountInfo::getUserID();
$eventID = $_GET['id'];
CheckEID::GeteID($eventID, $conn);


$stmt = $conn->prepare(
    "CALL removeEventGetName(:eventID)"
);
$stmt->bindParam(':eventID', $eventID);
$stmt->execute();
$event = $stmt->fetch();
$stmt = $conn->prepare(
    "CALL removeEventCount(:userID, :eventID)"
);
$stmt->bindParam(':userID', $userID);
$stmt->bindParam(':eventID', $eventID);
$stmt->execute();
$count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

if ($count > 0 || $role == 'admin') {
    if (isset($_POST['remove'])) {
        $stmt = $conn->prepare(
            "CALL removeEventDelete(:eventID)"
        );
        $stmt->bindParam(':eventID', $eventID);
        $stmt->execute();
        ?>myFunction()<?php ;
            header('Location: index.php?page=myEventsO');
        }
        } else {
            header("Location: " . TEMPLATE . '403.php');
        }
        ?>

<main>
    <h2>Removing '<?php echo htmlspecialchars($event['eventName']) ?>' cannot be undone!</h2>
    <form method="post" onsubmit='return confirm("Are you sure you want to remove this event listing?")'>
        <input type="submit" name="remove" value="Remove Event">
    </form>
    <a href="index.php?page=myEventsO"><button>Reurn to Events</button></a>
</main>