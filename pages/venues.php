<?php
    include('./connection/connectionString.php');
    $stmt = $conn->prepare("SELECT * FROM venue");
    $stmt->execute();
    $venues = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div>
    <?php
foreach ($venues as $venue) {
    ?>
    <h1><?php echo $venue['venueName']; ?></h1>
    <img class="venueImg" src="<?php echo $venue['venueImg']; ?>" alt="<?php echo $venue['venueName']; ?>">
    <p>Address: <?php echo $venue['venueAddress']. " ". $venue['venuePostalCode']; ?></p>
    <?php
}
?>
</div>