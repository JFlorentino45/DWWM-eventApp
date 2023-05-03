<?php
require_once('./connection/connectionString.php');
require_once('./classes/CheckVID.php');

$venueID = strip_tags(htmlspecialchars($_GET['id']));
CheckVID::GetvID($venueID, $conn);

$stmt = $conn->prepare(
    "CALL venueGetVenue(:venueID)"
);
$stmt->bindParam(':venueID', $venueID);
$stmt->execute();
$venue = $stmt->fetch();
?>

<main>
    <h1><?php echo htmlspecialchars($venue['venueName']); ?></h1>
    <img class="venue-img" src="<?php echo htmlspecialchars($venue['venueImg']); ?>" alt="<?php echo htmlspecialchars($venue['venueName']); ?>">
    <h3>Address: </h3>
    <p class='address'><?php echo htmlspecialchars($venue['venueAddress']). " ". htmlspecialchars($venue['venuePostalCode']); ?></p>
</main>