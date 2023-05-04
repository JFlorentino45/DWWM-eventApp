<?php
require_once('./connection/connectionString.php');
require_once('./classes/AccountInfo.php');

$role = strip_tags(htmlspecialchars(AccountInfo::getRole()));

if($role == 'admin'){
    $stmt = $conn->prepare(
        "CALL venuesGetAll()"
    );
    $stmt->execute();
    $venues = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    header("Location: ". TEMPLATE . '403.php');
}
?>

<main>
    <h1 class='title'>Venues</h1>
    <div class='venue-grid'>
        <?php
    foreach ($venues as $venue) {
        ?>
    <div class="venue" data-name='<?php echo htmlspecialchars($venue['venueName']); ?>'>
    <img class="venue-img" src="<?php echo htmlspecialchars($venue['venueImg']); ?>" alt="<?php echo htmlspecialchars($venue['venueName']); ?>">
    <div>
        <h2 class="venue-name"><?php echo htmlspecialchars($venue['venueName']); ?></h2>
        <p>Address: <?php echo htmlspecialchars($venue['venueAddress']). " ". htmlspecialchars($venue['venuePostalCode']); ?></p>
        <a href="index.php?page=editVenue&id=<?php echo htmlspecialchars($venue['venueID']) ?>"><button class='buttonD'>Edit</button></a>
    </div>
</div>
<?php
}
?>
</div>
</main>