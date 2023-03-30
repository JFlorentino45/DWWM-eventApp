<?php
    include('../connection/connectionString.php');
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM venue WHERE venueID = :id");
    $stmt->execute(['id' => $id]);
    $venue = $stmt->fetch();
?>
    <h1><?php echo $venue['venueName']; ?></h1>
    <img class="venueImg" src="<?php echo $venue['venueImg']; ?>" alt="<?php echo $venue['venueName']; ?>">
    <p>Address: <?php echo $venue['venueAddress']. " ". $venue['venuePostalCode']; ?></p>