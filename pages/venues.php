<?php
    include('./connection/connectionString.php');
    require_once('./classes/AccountInfo.php');
    $role = getRole();
    if($role == 'admin'){
        $stmt = $conn->prepare("SELECT * FROM venue");
        $stmt->execute();
        $venues = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        header("Location: ". TEMPLATE . '404.php');
    }
?>
<div>
    <?php
foreach ($venues as $venue) {
    ?>
    <h1><?php echo $venue['venueName']; ?></h1>
    <img class="venueImg" src="<?php echo $venue['venueImg']; ?>" alt="<?php echo $venue['venueName']; ?>">
    <p>Address: <?php echo $venue['venueAddress']. " ". $venue['venuePostalCode']; ?></p>
    <a href="index.php?page=editVenue&id=<?php echo $venue['venueID'] ?>"><button>Edit</button></a>
    <?php
}
?>
</div>