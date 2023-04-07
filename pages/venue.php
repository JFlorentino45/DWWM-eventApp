
<?php
require_once('./connection/connectionString.php');
require_once('./classes/CheckVID.php');

$venueID = $_GET['id'];
GetvID($venueID, $conn);

$stmt = $conn->prepare("CALL venueGetVenue(:venueID)");
$stmt->bindParam(':venueID', $venueID);
$stmt->execute();
$venue = $stmt->fetch();
?>

<main>
    <h1><?php echo htmlspecialchars($venue['venueName']); ?></h1>
    <img class="venueImg" src="<?php echo htmlspecialchars($venue['venueImg']); ?>" alt="<?php echo htmlspecialchars($venue['venueName']); ?>">
    <p>Address: <?php echo htmlspecialchars($venue['venueAddress']). " ". htmlspecialchars($venue['venuePostalCode']); ?></p>
</main>