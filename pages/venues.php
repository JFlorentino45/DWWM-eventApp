
<?php
    require_once('./connection/connectionString.php');
    require_once('./classes/AccountInfo.php');
    $role = getRole();
    if($role == 'admin'){
            $stmt = $conn->prepare("CALL venuesGetAll()");
            $stmt->execute();
            $venues = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        header("Location: ". TEMPLATE . '403.php');
    }
?>
<div>
    <?php
foreach ($venues as $venue) {
    ?>
    <h1><?php echo htmlspecialchars($venue['venueName']); ?></h1>
    <img class="venueImg" src="<?php echo htmlspecialchars($venue['venueImg']); ?>" alt="<?php echo htmlspecialchars($venue['venueName']); ?>">
    <p>Address: <?php echo htmlspecialchars($venue['venueAddress']). " ". htmlspecialchars($venue['venuePostalCode']); ?></p>
    <a href="index.php?page=editVenue&id=<?php echo htmlspecialchars($venue['venueID']) ?>"><button>Edit</button></a>
    <?php
}
?>
</div>