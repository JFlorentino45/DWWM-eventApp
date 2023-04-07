
<?php
require_once('./connection/connectionString.php');
$venueID = $_GET['id'];

try {
    $stmt = $conn->prepare("CALL venueGetVenue(:venueID)");
    $stmt->bindParam(':venueID', $venueID);
    $stmt->execute();
    $venue = $stmt->fetch();
} catch(PDOException $e){
    echo "Error executing the stored procedure: " . $e->getMessage();
}
?>

<main>
    <h1><?php echo $venue['venueName']; ?></h1>
    <img class="venueImg" src="<?php echo $venue['venueImg']; ?>" alt="<?php echo $venue['venueName']; ?>">
    <p>Address: <?php echo $venue['venueAddress']. " ". $venue['venuePostalCode']; ?></p>
</main>